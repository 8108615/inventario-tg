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
        $path = database_path('seeders/articulo.sql');

        if (!file_exists($path)) {
            $path = base_path('articulo.sql');
        }

        if (!file_exists($path)) {
            $this->command->error("No se encontró el archivo 'articulo.sql' en database/seeders/ ni en la raíz del proyecto.");
            return;
        }

        $this->command->info("Importando 'articulo.sql' en la base de datos...");

        // 1. Ejecutar el archivo SQL para crear y poblar la tabla 'articulo'
        $sql = file_get_contents($path);
        try {
            DB::unprepared($sql);
        } catch (\Exception $e) {
            // Si la tabla ya existe, continuamos sin problemas
        }

        if (!DB::getSchemaBuilder()->hasTable('articulo')) {
            $this->command->error("No se pudo crear la tabla 'articulo' a partir del archivo SQL.");
            return;
        }

        $categoriaPorDefecto = Categoria::first();
        $categoriaIdDefault = $categoriaPorDefecto ? $categoriaPorDefecto->id : 1;

        // 2. Traer los registros como arreglos para evitar errores de propiedades inexistentes
        $articulosAntiguos = DB::table('articulo')->get();
        $contador = 0;

        foreach ($articulosAntiguos as $antiguo) {
            // Convertir el objeto stdClass a un arreglo asociativo de forma segura
            $row = (array) $antiguo;

            // Limpiar la imagen (si está vacía o es 'NULL', se queda en null para que muestre S/F)
            $imagenRaw = trim(array_values(array_slice($row, 7, 1))[0] ?? ''); // Intento seguro de ubicar la columna de imagen o ajustamos abajo

            // Buscamos la columna de imagen de forma flexible (puedes cambiar 'imagen' por el nombre real si fuera distinto)
            $imagenVal = $row['imagen'] ?? null;
            $imagen = (!empty($imagenVal) && strtolower($imagenVal) !== 'null') ? trim($imagenVal) : null;

            Producto::create([
                'categoria_id' => $categoriaIdDefault,
                'codigo'       => $row['codigo'] ?? $row['codigo_barra'] ?? null,
                'nombre'       => !empty(trim($row['nombre'] ?? '')) ? trim($row['nombre']) : 'SIN NOMBRE',
                'marca'        => !empty(trim($row['marca'] ?? '')) ? trim($row['marca']) : null,
                'modelo'       => !empty(trim($row['modelo'] ?? '')) ? trim($row['modelo']) : null,
                'serie'        => !empty(trim($row['serie'] ?? '')) ? trim($row['serie']) : null,
                'stock'        => isset($row['stock']) ? (int)$row['stock'] : 1,
                'imagen'       => $imagen, // Guarda el nombre de la imagen o null para que muestre S/F
                'estado'       => 'Activo',
            ]);

            $contador++;
        }

        $this->command->info("¡Se migraron los {$contador} productos exitosamente con sus imágenes!");
    }
}
