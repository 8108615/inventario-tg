<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductoController extends Controller
{

    public function index(Request $request)
    {
        // Obtener el texto del buscador
        $buscar = trim($request->input('buscar', ''));

        // Obtener la cantidad de productos por página
        // Por defecto se mostrarán 10 productos
        $porPagina = (int) $request->input('por_pagina', 10);

        // Permitir únicamente 10, 25, 50 o 100 productos
        if (!in_array($porPagina, [10, 25, 50, 100], true)) {
            $porPagina = 10;
        }

        // Consultar productos activos y eliminados
        $productos = Producto::withTrashed()
            ->with(['categoria' => function ($query) {
                $query->withTrashed();
            }])

            // Buscar en los campos del producto
            ->when($buscar !== '', function ($query) use ($buscar) {
                $query->where(function ($q) use ($buscar) {

                    $q->where('codigo', 'like', "%{$buscar}%")
                    ->orWhere('nombre', 'like', "%{$buscar}%")
                    ->orWhere('marca', 'like', "%{$buscar}%")
                    ->orWhere('modelo', 'like', "%{$buscar}%")
                    ->orWhere('serie', 'like', "%{$buscar}%")

                    // Buscar también por categoría
                    ->orWhereHas('categoria', function ($categoria) use ($buscar) {
                        $categoria->withTrashed()
                            ->where('nombre', 'like', "%{$buscar}%");
                    });
                });
            })

            // Ordenar desde el producto más reciente
            ->orderBy('id', 'desc')

            // Mostrar la cantidad seleccionada por página
            ->paginate($porPagina)

            // Mantener la búsqueda y cantidad al cambiar de página
            ->withQueryString();

        // Enviar los datos a la vista
        return view('admin.productos.index', compact(
            'productos',
            'buscar',
            'porPagina'
        ));
    }

    public function exportarCsv(Request $request)
    {
        $buscar = trim((string) $request->input('buscar', ''));

        $query = Producto::withTrashed()
            ->with(['categoria' => function ($query) {
                $query->withTrashed();
            }])
            ->when($buscar !== '', function ($query) use ($buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('codigo', 'like', "%{$buscar}%")
                    ->orWhere('nombre', 'like', "%{$buscar}%")
                    ->orWhere('marca', 'like', "%{$buscar}%")
                    ->orWhere('modelo', 'like', "%{$buscar}%")
                    ->orWhere('serie', 'like', "%{$buscar}%")
                    ->orWhereHas('categoria', function ($categoria) use ($buscar) {
                        $categoria->withTrashed()
                            ->where('nombre', 'like', "%{$buscar}%");
                    });
                });
            })
            ->orderBy('id', 'desc');

        $nombreArchivo = 'inventario_the_game_' . date('Y-m-d_H-i-s') . '.csv';

        return response()->streamDownload(function () use ($query) {

            $archivo = fopen('php://output', 'w');

            // BOM UTF-8 para mostrar correctamente tildes y ñ en Excel
            fwrite($archivo, "\xEF\xBB\xBF");

            // Encabezados del archivo CSV
            fputcsv($archivo, [
                'Nro',
                'Codigo',
                'Nombre',
                'Categoria',
                'Marca',
                'Modelo',
                'Serie',
                'Stock',
                'Estado'
            ], ';');

            $numero = 1;

            foreach ($query->lazy(200) as $producto) {

                $estado = ($producto->deleted_at ||
                        $producto->estado === 'Inactivo')
                    ? 'Inactivo'
                    : 'Activo';

                fputcsv($archivo, [
                    $numero++,
                    $producto->codigo ?? '',
                    $producto->nombre,
                    $producto->categoria?->nombre ?? 'N/A',
                    $producto->marca ?? '',
                    $producto->modelo ?? '',
                    $producto->serie ?? '',
                    $producto->stock,
                    $estado
                ], ';');
            }

            fclose($archivo);

        }, $nombreArchivo, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function exportarExcel(Request $request)
    {
        $buscar = trim((string) $request->input('buscar', ''));

        $query = Producto::withTrashed()
            ->with(['categoria' => function ($query) {
                $query->withTrashed();
            }])
            ->when($buscar !== '', function ($query) use ($buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('codigo', 'like', "%{$buscar}%")
                    ->orWhere('nombre', 'like', "%{$buscar}%")
                    ->orWhere('marca', 'like', "%{$buscar}%")
                    ->orWhere('modelo', 'like', "%{$buscar}%")
                    ->orWhere('serie', 'like', "%{$buscar}%")
                    ->orWhereHas('categoria', function ($categoria) use ($buscar) {
                        $categoria->withTrashed()
                            ->where('nombre', 'like', "%{$buscar}%");
                    });
                });
            })
            ->orderBy('id', 'desc');

        $excel = new Spreadsheet();
        $hoja = $excel->getActiveSheet();
        $hoja->setTitle('Inventario');

        // Título principal
        $hoja->mergeCells('A1:I1');
        $hoja->setCellValue('A1', 'THE GAME SRL - INVENTARIO DE PRODUCTOS');

        $hoja->getStyle('A1:I1')->getFont()
            ->setBold(true)
            ->setSize(16)
            ->getColor()->setRGB('FFFFFF');

        $hoja->getStyle('A1:I1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('123B73');

        $hoja->getStyle('A1:I1')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $hoja->getRowDimension(1)->setRowHeight(32);

        // Encabezados
        $encabezados = [
            'Nro', 'Código', 'Nombre', 'Categoría',
            'Marca', 'Modelo', 'Serie', 'Stock', 'Estado'
        ];

        foreach ($encabezados as $indice => $titulo) {
            $columna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($indice + 1);
            $hoja->setCellValue($columna . '3', $titulo);
        }

        $hoja->getStyle('A3:I3')->getFont()
            ->setBold(true)
            ->getColor()->setRGB('FFFFFF');

        $hoja->getStyle('A3:I3')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('2563EB');

        $hoja->getRowDimension(3)->setRowHeight(24);

        // Registrar todos los productos
        $fila = 4;
        $numero = 1;

        foreach ($query->lazy(200) as $producto) {

            $estado = ($producto->deleted_at ||
                    $producto->estado === 'Inactivo')
                ? 'Inactivo'
                : 'Activo';

            $hoja->setCellValue('A' . $fila, $numero++);

            // Conservar los códigos y números de serie como texto
            $hoja->setCellValueExplicit(
                'B' . $fila,
                (string) ($producto->codigo ?? ''),
                DataType::TYPE_STRING
            );

            $hoja->setCellValue('C' . $fila, $producto->nombre);
            $hoja->setCellValue('D' . $fila, $producto->categoria?->nombre ?? 'N/A');
            $hoja->setCellValue('E' . $fila, $producto->marca ?? '');
            $hoja->setCellValue('F' . $fila, $producto->modelo ?? '');

            $hoja->setCellValueExplicit(
                'G' . $fila,
                (string) ($producto->serie ?? ''),
                DataType::TYPE_STRING
            );

            $hoja->setCellValue('H' . $fila, $producto->stock);
            $hoja->setCellValue('I' . $fila, $estado);

            $fila++;
        }

        // Filtros y encabezado fijo
        $ultimaFila = max(3, $fila - 1);
        $hoja->setAutoFilter('A3:I' . $ultimaFila);
        $hoja->freezePane('A4');

        // Ancho de columnas
        $anchos = [
            'A' => 8,
            'B' => 22,
            'C' => 45,
            'D' => 25,
            'E' => 22,
            'F' => 25,
            'G' => 28,
            'H' => 12,
            'I' => 15,
        ];

        foreach ($anchos as $columna => $ancho) {
            $hoja->getColumnDimension($columna)->setWidth($ancho);
        }

        $hoja->getStyle('A3:I' . $ultimaFila)
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER);

        $nombreArchivo = 'inventario_the_game_' . date('Y-m-d_H-i-s') . '.xlsx';

        $rutaTemporal = tempnam(sys_get_temp_dir(), 'inventario_tg_');

        if ($rutaTemporal === false) {
            throw new \RuntimeException('No se pudo crear el archivo temporal.');
        }

        try {
            $writer = new Xlsx($excel);
            $writer->save($rutaTemporal);

            return response()->download(
                $rutaTemporal,
                $nombreArchivo,
                ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
            )->deleteFileAfterSend(true);

        } catch (\Throwable $e) {
            if (is_file($rutaTemporal)) {
                unlink($rutaTemporal);
            }

            throw $e;

        } finally {
            $excel->disconnectWorksheets();
            unset($excel);
        }
    }

    public function copiarProductos(Request $request)
    {
        $buscar = trim((string) $request->input('buscar', ''));

        $query = Producto::withTrashed()
            ->with(['categoria' => function ($query) {
                $query->withTrashed();
            }])
            ->when($buscar !== '', function ($query) use ($buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('codigo', 'like', "%{$buscar}%")
                        ->orWhere('nombre', 'like', "%{$buscar}%")
                        ->orWhere('marca', 'like', "%{$buscar}%")
                        ->orWhere('modelo', 'like', "%{$buscar}%")
                        ->orWhere('serie', 'like', "%{$buscar}%")
                        ->orWhereHas('categoria', function ($categoria) use ($buscar) {
                            $categoria->withTrashed()
                                ->where('nombre', 'like', "%{$buscar}%");
                        });
                });
            })
            ->orderBy('id', 'desc');

        $lineas = [
            implode("\t", [
                'Nro', 'Código', 'Nombre', 'Categoría',
                'Marca', 'Modelo', 'Serie', 'Stock', 'Estado'
            ])
        ];

        $numero = 1;

        foreach ($query->lazy(200) as $producto) {
            $estado = ($producto->deleted_at || $producto->estado === 'Inactivo')
                ? 'Inactivo'
                : 'Activo';

            $valores = [
                $numero++,
                $producto->codigo ?? '',
                $producto->nombre,
                $producto->categoria?->nombre ?? 'N/A',
                $producto->marca ?? '',
                $producto->modelo ?? '',
                $producto->serie ?? '',
                $producto->stock,
                $estado,
            ];

            $valores = array_map(function ($valor) {
                $texto = str_replace(["\t", "\r", "\n"], ' ', (string) $valor);

                // Evitar que Excel interprete contenido como fórmula.
                if (preg_match('/^\s*[=+\-@]/u', $texto)) {
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


    public function exportarPdf(Request $request)
    {
        $buscar = trim((string) $request->input('buscar', ''));

        $query = Producto::withTrashed()
            ->with(['categoria' => function ($query) {
                $query->withTrashed();
            }])
            ->when($buscar !== '', function ($query) use ($buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('codigo', 'like', "%{$buscar}%")
                    ->orWhere('nombre', 'like', "%{$buscar}%")
                    ->orWhere('marca', 'like', "%{$buscar}%")
                    ->orWhere('modelo', 'like', "%{$buscar}%")
                    ->orWhere('serie', 'like', "%{$buscar}%")
                    ->orWhereHas('categoria', function ($categoria) use ($buscar) {
                        $categoria->withTrashed()
                            ->where('nombre', 'like', "%{$buscar}%");
                    });
                });
            })
            ->orderBy('id', 'desc');

        // Obtener los productos sin aplicar la paginación del listado.
        $productos = $query->get();

        $pdf = Pdf::loadView('admin.productos.pdf', [
            'productos' => $productos,
            'buscar' => $buscar,
            'fecha' => now()->format('d/m/Y H:i'),
        ])->setPaper('a4', 'landscape');

        $nombreArchivo = 'inventario_the_game_' .
            date('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($nombreArchivo);
    }

    public function create()
    {
        $categorias = Categoria::where('estado', 'Activo')->get();
        return view('admin.productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre'       => 'required|string|max:255',
            'codigo'       => 'nullable|string|max:255|unique:productos,codigo',
            'marca'        => 'nullable|string|max:255',
            'modelo'       => 'nullable|string|max:255',
            'serie'        => 'nullable|string|max:255',
            'stock'        => 'required|integer|min:0',
            'estado'       => 'required|in:Activo,Inactivo',
            'imagen'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Manejo de la imagen (Guarda únicamente con el nombre original limpio sin números al inicio)
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('productos'), $filename);
            $data['imagen'] = $filename;
        }

        Producto::create($data);

        return redirect()->route('admin.productos.index')->with([
            'mensaje' => 'Producto registrado correctamente',
            'icono' => 'success'
        ]);
    }

    public function show(string $id)
    {
        $producto = Producto::with('categoria')->withTrashed()->findOrFail($id);
        return view('admin.productos.show', compact('producto'));
    }

    public function edit(string $id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::where('estado', 'Activo')->get();
        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, string $id)
    {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre'       => 'required|string|max:255',
            'codigo'       => 'nullable|string|max:255|unique:productos,codigo,' . $producto->id,
            'marca'        => 'nullable|string|max:255',
            'modelo'       => 'nullable|string|max:255',
            'serie'        => 'nullable|string|max:255',
            'stock'        => 'required|integer|min:0',
            'estado'       => 'required|in:Activo,Inactivo',
            'imagen'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Manejo de la imagen (Guarda únicamente con el nombre original limpio sin números al inicio)
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('productos'), $filename);
            $data['imagen'] = $filename;
        }

        $producto->update($data);

        return redirect()->route('admin.productos.index')->with([
            'mensaje' => 'Producto actualizado correctamente',
            'icono' => 'success'
        ]);
    }

    public function restaurar($id)
    {
        $producto = Producto::withTrashed()->findOrFail($id);
        $producto->restore();

        return redirect()
        ->route('admin.productos.index')
        ->with([
            'mensaje' => 'Producto restaurado correctamente.',
            'icono' => 'success',
        ]);
    }

    public function destroy(string $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('admin.productos.index')->with([
            'mensaje' => 'Producto eliminado correctamente',
            'icono' => 'success'
        ]);
    }

    public function getProductos(Request $request)
    {
        $query = Producto::query()
        ->select([
            'id',
            'categoria_id',
            'codigo',
            'nombre',
            'marca',
            'modelo',
            'serie',
            'stock',
            'imagen',
            'estado',
            'deleted_at',
        ])
        ->with('categoria:id,nombre')
        ->withTrashed();
        $user = auth()->user();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('imagen_html', function ($producto) {
                if ($producto->imagen && file_exists(public_path('productos/' . $producto->imagen))) {
                    return '<img src="' . asset('productos/' . $producto->imagen) . '" alt="Foto" class="w-12 h-12 object-cover rounded-md shadow mx-auto">';
                }
                return '<span class="text-xs text-gray-400 italic">S/F</span>';
            })
            ->addColumn('categoria_nombre', function ($producto) {
                return '<span class="bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 text-xs font-semibold px-2.5 py-0.5 rounded">' . ($producto->categoria->nombre ?? 'N/A') . '</span>';
            })
            ->addColumn('marca_col', function ($producto) {
                return '<span class="text-sm font-medium text-gray-900 dark:text-gray-100">' . ($producto->marca ?? 'S/M') . '</span>';
            })
            ->addColumn('modelo_col', function ($producto) {
                return '<span class="text-sm text-gray-700 dark:text-gray-300">' . ($producto->modelo ?? 'S/M') . '</span>';
            })
            ->addColumn('serie_col', function ($producto) {
                return '<span class="text-sm text-gray-700 dark:text-gray-300">' . ($producto->serie ?? 'S/N') . '</span>';
            })
            ->addColumn('codigo_barra_col', function ($producto) {
                return '<span class="font-mono text-xs font-semibold text-gray-900 dark:text-gray-100">' . ($producto->codigo ?? 'N/A') . '</span>';
            })
            ->addColumn('estado_html', function ($producto) {
                if ($producto->deleted_at) {
                    return '<span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-red-500 text-white">Inactivo</span>';
                }
                return '<span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-emerald-500 text-white">Activo</span>';
            })
            ->addColumn('acciones', function ($producto) use ($user) {
                $csrfToken = csrf_token();
                $nombreProducto = addslashes($producto->nombre);
                $html = '<div class="flex justify-center gap-1">';

                // Si el producto está eliminado (SoftDelete)
                if ($producto->deleted_at) {
                    if ($user->can('Restaurar Producto')) {
                        $urlRestaurar = route('admin.productos.restaurar', $producto->id);
                        $html .= '<form action="' . $urlRestaurar . '" method="POST" id="formRestaurarProducto' . $producto->id . '" class="inline">' .
                                 '<input type="hidden" name="_token" value="' . $csrfToken . '">' .
                                 '<button type="submit" class="inline-flex items-center px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold rounded transition cursor-pointer" onclick="confirmarRestauracionProducto' . $producto->id . '(event)">Restaurar</button>' .
                                 '</form>' .
                                 '<script>' .
                                 'function confirmarRestauracionProducto' . $producto->id . '(event) {' .
                                 '    event.preventDefault();' .
                                 '    Swal.fire({' .
                                 '        title: "¿Desea restaurar el producto \\"' . $nombreProducto . '\\"?",' .
                                 '        icon: "question",' .
                                 '        showCancelButton: true,' .
                                 '        confirmButtonText: "Restaurar",' .
                                 '        confirmButtonColor: "#ca8a04",' .
                                 '        cancelButtonText: "Cancelar"' .
                                 '    }).then((result) => {' .
                                 '        if (result.isConfirmed) {' .
                                 '            document.getElementById("formRestaurarProducto' . $producto->id . '").submit();' .
                                 '        }' .
                                 '    });' .
                                 '}' .
                                 '</script>';
                    }
                } else {
                    // Si está activo, evaluamos cada botón según los permisos del usuario
                    if ($user->can('Ver Producto')) {
                        $urlShow = route('admin.productos.show', ['id' => $producto->id]);
                        $html .= '<a href="' . $urlShow . '" class="inline-flex items-center px-3 py-1.5 bg-zinc-500 hover:bg-zinc-600 text-white text-xs font-semibold rounded transition shadow-sm">Ver</a>';
                    }

                    if ($user->can('Editar Producto')) {
                        $urlEdit = route('admin.productos.edit', ['id' => $producto->id]);
                        $html .= '<a href="' . $urlEdit . '" class="inline-flex items-center px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-semibold rounded transition">Editar</a>';
                    }

                    if ($user->can('Eliminar Producto')) {
                        $urlDestroy = route('admin.productos.destroy', $producto->id);
                        $html .= '<form action="' . $urlDestroy . '" method="POST" id="formEliminarProducto' . $producto->id . '" class="inline">' .
                                 '<input type="hidden" name="_token" value="' . $csrfToken . '">' .
                                 '<input type="hidden" name="_method" value="DELETE">' .
                                 '<button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded transition cursor-pointer" onclick="confirmarEliminacionProducto' . $producto->id . '(event)">Eliminar</button>' .
                                 '</form>' .
                                 '<script>' .
                                 'function confirmarEliminacionProducto' . $producto->id . '(event) {' .
                                 '    event.preventDefault();' .
                                 '    Swal.fire({' .
                                 '        title: "¿Desea eliminar el producto \\"' . $nombreProducto . '\\"?",' .
                                 '        icon: "warning",' .
                                 '        showCancelButton: true,' .
                                 '        confirmButtonText: "Eliminar",' .
                                 '        confirmButtonColor: "#a5161d",' .
                                 '        cancelButtonText: "Cancelar"' .
                                 '    }).then((result) => {' .
                                 '        if (result.isConfirmed) {' .
                                 '            document.getElementById("formEliminarProducto' . $producto->id . '").submit();' .
                                 '        }' .
                                 '    });' .
                                 '}' .
                                 '</script>';
                    }
                }

                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['imagen_html', 'categoria_nombre', 'marca_col', 'modelo_col', 'serie_col', 'codigo_barra_col', 'estado_html', 'acciones'])
            ->make(true);
    }
}
