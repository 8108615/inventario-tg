<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Categoria;

class ProductoAntiguoSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/productos.csv');

        if (!file_exists($path)) {
            $path = base_path('productos.csv');
        }

        if (!file_exists($path)) {
            $this->command->error("No se encontró el archivo 'productos.csv' en database/seeders/ ni en la raíz del proyecto.");
            return;
        }

        // Leer todo el contenido y forzar conversión a UTF-8 para evitar errores de caracteres
        $contenido = file_get_contents($path);
        $codificacion = mb_detect_encoding($contenido, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true);
        if ($codificacion && $codificacion !== 'UTF-8') {
            $contenido = mb_convert_encoding($contenido, 'UTF-8', $codificacion);
        }

        $lineas = explode("\n", $contenido);

        // Detectar delimitador (, o ;)
        $delimiter = (strpos($lineas[0], ';') !== false) ? ';' : ',';

        // Omitir la primera línea (cabecera)
        array_shift($lineas);

        $contador = 0;

        foreach ($lineas as $linea) {
            if (trim($linea) === '') continue;

            $row = str_getcsv($linea, $delimiter);

            // Estructura del CSV:
            // [0] Opciones, [1] Nombre, [2] Marca, [3] Modelo, [4] Serie, [5] Cantidad, [6] Ubicacion del Equipo, [7] Imagen, [8] Codigo de Barra, [9] Estado

            $nombreCategoria = trim($row[6] ?? '');
            if (empty($nombreCategoria)) continue;

            $categoria = Categoria::where('nombre', $nombreCategoria)->first();
            if (!$categoria) continue;

            $nombre = !empty(trim($row[1] ?? '')) ? trim($row[1]) : 'SIN NOMBRE';
            $marca = !empty(trim($row[2] ?? '')) ? trim($row[2]) : null;
            $modelo = !empty(trim($row[3] ?? '')) ? trim($row[3]) : null;
            $serie = !empty(trim($row[4] ?? '')) ? trim($row[4]) : null;
            $stock = is_numeric($row[5] ?? null) ? (int)$row[5] : 1;
            $imagen = !empty(trim($row[7] ?? '')) ? trim($row[7]) : null;
            $codigo = !empty(trim($row[8] ?? '')) ? trim($row[8]) : null;
            $estadoCsv = trim($row[9] ?? 'Activado');
            $estado = ($estadoCsv === 'Activado' || $estadoCsv === 'Activo') ? 'Activo' : 'Inactivo';

            Producto::create([
                'categoria_id' => $categoria->id,
                'codigo' => $codigo,
                'nombre' => $nombre,
                'marca' => $marca,
                'modelo' => $modelo,
                'serie' => $serie,
                'stock' => $stock,
                'imagen' => $imagen,
                'estado' => $estado,
            ]);

            $contador++;
        }

        $this->command->info("¡Se migraron {$contador} productos exitosamente!");
    }
}
