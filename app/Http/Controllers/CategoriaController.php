<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Barryvdh\DomPDF\Facade\Pdf;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener el texto del buscador
        $buscar = trim($request->input('buscar', ''));

        // Obtener la cantidad de categorías por página
        // Por defecto se mostrarán 10 categorías
        $porPagina = (int) $request->input('por_pagina', 10);

        // Permitir únicamente 10, 25, 50 o 100 categorías
        if (!in_array($porPagina, [10, 25, 50, 100], true)) {
            $porPagina = 10;
        }

        // Consultar categorías activas y eliminadas
        $categorias = Categoria::withTrashed()

            // Buscar por nombre o descripción
            ->when($buscar !== '', function ($query) use ($buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('descripcion', 'like', "%{$buscar}%");
                });
            })

            // Ordenar desde la categoría más reciente
            ->orderBy('id', 'desc')

            // Mostrar la cantidad seleccionada por página
            ->paginate($porPagina)

            // Mantener la búsqueda y cantidad al cambiar de página
            ->withQueryString();

        // Enviar los datos a la vista
        return view('admin.categorias.index', compact(
            'categorias',
            'buscar',
            'porPagina'
        ));
    }

    public function exportarCsv(Request $request)
    {
        $buscar = trim((string) $request->input('buscar', ''));

        $query = Categoria::withTrashed()
            ->when($buscar !== '', function ($query) use ($buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('descripcion', 'like', "%{$buscar}%");
                });
            })
            ->orderBy('id', 'desc');

        $nombreArchivo = 'categorias_the_game_' .
            date('Y-m-d_H-i-s') . '.csv';

        return response()->streamDownload(function () use ($query) {

            $archivo = fopen('php://output', 'w');

            // UTF-8 para visualizar acentos correctamente en Excel
            fwrite($archivo, "\xEF\xBB\xBF");

            // Encabezados
            fputcsv($archivo, [
                'Nro',
                'Nombre',
                'Descripción',
                'Estado'
            ], ';');

            $numero = 1;

            foreach ($query->lazy(200) as $categoria) {

                $estado = ($categoria->deleted_at ||
                    $categoria->estado === 'Inactivo')
                    ? 'Inactivo'
                    : 'Activo';

                $valores = [
                    $numero++,
                    $categoria->nombre,
                    $categoria->descripcion ?? '',
                    $estado
                ];

                // Evitar que Excel interprete textos como fórmulas
                $valores = array_map(function ($valor) {
                    $texto = (string) $valor;

                    if (preg_match('/^[\s]*[=+\-@]/u', $texto)) {
                        $texto = "'" . $texto;
                    }

                    return $texto;
                }, $valores);

                fputcsv($archivo, $valores, ';');
            }

            fclose($archivo);

        }, $nombreArchivo, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Cache-Control' => 'no-store'
        ]);
    }

    
    public function exportarExcel(Request $request)
    {
        $buscar = trim((string) $request->input('buscar', ''));

        // Obtener categorías activas y eliminadas
        $query = Categoria::withTrashed()
            ->when($buscar !== '', function ($query) use ($buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('descripcion', 'like', "%{$buscar}%");
                });
            })
            ->orderBy('id', 'desc');

        // Crear archivo Excel
        $spreadsheet = new Spreadsheet();
        $hoja = $spreadsheet->getActiveSheet();
        $hoja->setTitle('Categorías');

        // Título principal
        $hoja->mergeCells('A1:D1');
        $hoja->setCellValue('A1', 'THE GAME SRL - LISTADO DE CATEGORÍAS');

        $hoja->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 15,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1E3A5F'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $hoja->getRowDimension(1)->setRowHeight(35);

        // Información del reporte
        $hoja->setCellValue('A2', 'Fecha de emisión:');
        $hoja->setCellValue('B2', now()->format('d/m/Y H:i'));

        $hoja->setCellValue('A3', 'Filtro aplicado:');
        $hoja->setCellValue('B3', $buscar !== '' ? $buscar : 'Todos');

        // Encabezados
        $encabezados = [
            'A5' => 'Nro',
            'B5' => 'Nombre',
            'C5' => 'Descripción',
            'D5' => 'Estado',
        ];

        foreach ($encabezados as $celda => $texto) {
            $hoja->setCellValue($celda, $texto);
        }

        $hoja->getStyle('A5:D5')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2563EB'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Insertar categorías
        $fila = 6;
        $numero = 1;

        foreach ($query->lazy(200) as $categoria) {

            $estado = ($categoria->deleted_at ||
                $categoria->estado === 'Inactivo')
                ? 'Inactivo'
                : 'Activo';

            $hoja->setCellValue('A' . $fila, $numero++);

            $hoja->setCellValueExplicit(
                'B' . $fila,
                (string) $categoria->nombre,
                DataType::TYPE_STRING
            );

            $hoja->setCellValueExplicit(
                'C' . $fila,
                (string) ($categoria->descripcion ?? ''),
                DataType::TYPE_STRING
            );

            $hoja->setCellValue('D' . $fila, $estado);

            // Filas alternadas
            if ($fila % 2 === 0) {
                $hoja->getStyle("A{$fila}:D{$fila}")
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('F1F5F9');
            }

            $fila++;
        }

        // Ajustar columnas
        $hoja->getColumnDimension('A')->setWidth(10);
        $hoja->getColumnDimension('B')->setWidth(30);
        $hoja->getColumnDimension('C')->setWidth(75);
        $hoja->getColumnDimension('D')->setWidth(18);

        // Congelar encabezados
        $hoja->freezePane('A6');

        // Filtros de Excel
        $ultimaFila = max(5, $fila - 1);
        $hoja->setAutoFilter("A5:D{$ultimaFila}");

        // Nombre del archivo
        $nombreArchivo = 'categorias_the_game_' .
            date('Y-m-d_H-i-s') . '.xlsx';

        // Descargar archivo
        return response()->streamDownload(
            function () use ($spreadsheet) {
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
                $spreadsheet->disconnectWorksheets();
            },
            $nombreArchivo,
            [
                'Content-Type' =>
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Cache-Control' => 'no-store',
            ]
        );
    }

    public function exportarPdf(Request $request)
    {
        $buscar = trim((string) $request->input('buscar', ''));

        // Consultar categorías activas y eliminadas
        $query = Categoria::withTrashed()
            ->when($buscar !== '', function ($query) use ($buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('descripcion', 'like', "%{$buscar}%");
                });
            })
            ->orderBy('id', 'desc');

        // Obtener todas las categorías sin paginación
        $categorias = $query->get();

        // Generar PDF
        $pdf = Pdf::loadView('admin.categorias.pdf', [
            'categorias' => $categorias,
            'buscar' => $buscar,
            'fecha' => now()->format('d/m/Y H:i'),
        ])->setPaper('a4', 'landscape');

        $nombreArchivo = 'categorias_the_game_' .
            date('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($nombreArchivo);
    }

    
    public function copiarCategorias(Request $request)
    {
        $buscar = trim($request->input('buscar', ''));

        $query = Categoria::withTrashed()
            ->when($buscar !== '', function ($query) use ($buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('descripcion', 'like', "%{$buscar}%");
                });
            })
            ->orderBy('id', 'desc');

        $lineas = [
            implode("\t", ['Nro', 'Nombre', 'Descripción', 'Estado'])
        ];

        $numero = 1;

        foreach ($query->lazy(200) as $categoria) {
            $estado = ($categoria->deleted_at || $categoria->estado === 'Inactivo')
                ? 'Inactivo'
                : 'Activo';

            $valores = [
                $numero++,
                $categoria->nombre,
                $categoria->descripcion ?? '',
                $estado,
            ];

            $valores = array_map(function ($valor) {
                $texto = str_replace(["\t", "\r", "\n"], ' ', (string) $valor);

                // Evitar que Excel interprete el contenido como fórmula
                if (preg_match('/^[=+\-@]/u', $texto)) {
                    $texto = "'" . $texto;
                }

                return $texto;
            }, $valores);

            $lineas[] = implode("\t", $valores);
        }

        return response(implode("\r\n", $lineas))
            ->header('Content-Type', 'text/plain; charset=UTF-8')
            ->header('Cache-Control', 'no-store');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:Activo,Inactivo',
        ]);

        Categoria::create($request->all());

        return redirect()->route('admin.categorias.index')->with([
            'mensaje' => 'Categoría registrada correctamente',
            'icono' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categoria = Categoria::withTrashed()->findOrFail($id);
        return view('admin.categorias.show', compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('admin.categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $categoria = Categoria::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $categoria->id,
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:Activo,Inactivo',
        ]);

        $categoria->update($request->all());

        return redirect()->route('admin.categorias.index')->with([
            'mensaje' => 'Categoría actualizada correctamente',
            'icono' => 'success'
        ]);
    }

    /**
     * Restore the specified resource.
     */
    public function restaurar($id)
    {
        $categoria = Categoria::withTrashed()->findOrFail($id);
        $categoria->restore();

        return redirect()->back()->with('success', 'Categoría restaurada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return redirect()->route('admin.categorias.index')->with([
            'mensaje' => 'Categoría eliminada correctamente',
            'icono' => 'success'
        ]);
    }
}
