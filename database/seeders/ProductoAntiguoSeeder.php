<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;

class ProductoAntiguoSeeder extends Seeder
{
    public function run(): void
    {
        $pathArticulo = database_path('seeders/articulo.sql');
        $pathCategoria = database_path('seeders/categoria.sql');

        if (!file_exists($pathArticulo)) {
            $this->command->error("No se encontró el archivo 'articulo.sql' en database/seeders/.");
            return;
        }

        $this->command->info("Importando tablas antiguas de respaldo para mapeo...");

        // 1. Cargar las tablas SQL antiguas de forma segura si no existen
        try {
            DB::unprepared(file_get_contents($pathArticulo));
        } catch (\Exception $e) {}

        if (file_exists($pathCategoria)) {
            try {
                DB::unprepared(file_get_contents($pathCategoria));
            } catch (\Exception $e) {}
        }

        if (!DB::getSchemaBuilder()->hasTable('articulo')) {
            $this->command->error("No se pudo leer la tabla 'articulo'.");
            return;
        }

        // 2. Traer todos los artículos antiguos
        $articulosAntiguos = DB::table('articulo')->get();
        $contador = 0;

        $tieneTablaCategoriaAntigua = DB::getSchemaBuilder()->hasTable('categoria');

        foreach ($articulosAntiguos as $antiguo) {
            $row = (array) $antiguo;

            $categoriaIdFinal = 1;

            if ($tieneTablaCategoriaAntigua && isset($row['idcategoria'])) {
                $catAntigua = DB::table('categoria')->where('idcategoria', $row['idcategoria'])->first();

                if ($catAntigua) {
                    $catNueva = Categoria::where('nombre', trim($catAntigua->nombre))->first();
                    if ($catNueva) {
                        $categoriaIdFinal = $catNueva->id;
                    }
                }
            }

            // Limpiar la imagen
            $imagenVal = $row['imagen'] ?? null;
            $imagen = (!empty($imagenVal) && strtolower($imagenVal) !== 'null') ? trim($imagenVal) : null;

            // Mapear la descripción antigua al campo 'serie' del nuevo sistema
            $serieVal = $row['descripcion'] ?? null;
            $serie = (!empty(trim($serieVal)) && strtolower(trim($serieVal)) !== 'null') ? trim($serieVal) : null;

            Producto::create([
                'categoria_id' => $categoriaIdFinal,
                'codigo'       => $row['codigo'] ?? $row['codigo_barra'] ?? null,
                'nombre'       => !empty(trim($row['nombre'] ?? '')) ? trim($row['nombre']) : 'SIN NOMBRE',
                'marca'        => !empty(trim($row['marca'] ?? '')) ? trim($row['marca']) : null,
                'modelo'       => !empty(trim($row['modelo'] ?? '')) ? trim($row['modelo']) : null,
                'serie'        => $serie, // ¡Aquí asignamos la serie real que estaba en la descripción!
                'stock'        => isset($row['stock']) ? (int)$row['stock'] : 1,
                'imagen'       => $imagen,
                'estado'       => 'Activo',
            ]);

            $contador++;
        }

        $this->command->info("¡Se migraron los {$contador} productos con sus series y categorías sincronizadas correctamente!");
    }
}
