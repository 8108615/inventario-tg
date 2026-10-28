<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.productos.index');
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
            'nombre' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'estado' => 'required|in:Activo,Inactivo',
        ]);

        $data = $request->all();

        // Manejo de la imagen si se sube una nueva
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = time() . '_' . $file->getClientOriginalName();
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
            'nombre' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'estado' => 'required|in:Activo,Inactivo',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = time() . '_' . $file->getClientOriginalName();
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

        return redirect()->back()->with('success', 'Producto restaurado correctamente.');
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
        $query = Producto::with('categoria')->withTrashed();

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
            ->addColumn('acciones', function ($producto) {
                $urlShow = route('admin.productos.show', ['id' => $producto->id]);
                $urlEdit = route('admin.productos.edit', ['id' => $producto->id]);
                $urlDestroy = route('admin.productos.destroy', $producto->id);
                $csrfToken = csrf_token();

                return '<div class="flex justify-center gap-1">' .
                       '<a href="' . $urlShow . '" class="inline-flex items-center px-3 py-1.5 bg-zinc-500 hover:bg-zinc-600 text-white text-xs font-semibold rounded transition shadow-sm">Ver</a>' .
                       '<a href="' . $urlEdit . '" class="inline-flex items-center px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-semibold rounded transition">Editar</a>' .
                       '<form action="' . $urlDestroy . '" method="POST" id="formEliminarProducto' . $producto->id . '" class="inline">' .
                       '<input type="hidden" name="_token" value="' . $csrfToken . '">' .
                       '<input type="hidden" name="_method" value="DELETE">' .
                       '<button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded transition cursor-pointer" onclick="confirmarEliminacionProducto' . $producto->id . '(event)">Eliminar</button>' .
                       '</form>' .
                       '</div>' .
                       '<script>' .
                       'function confirmarEliminacionProducto' . $producto->id . '(event) {' .
                       '    event.preventDefault();' .
                       '    Swal.fire({' .
                       '        title: "¿Desea eliminar este producto?",' .
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
            })
            ->rawColumns(['imagen_html', 'categoria_nombre', 'marca_col', 'modelo_col', 'serie_col', 'codigo_barra_col', 'estado_html', 'acciones'])
            ->make(true);
    }
}
