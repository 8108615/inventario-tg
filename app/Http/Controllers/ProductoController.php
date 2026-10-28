<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $productos = Producto::with('categoria')
            ->withTrashed()
            ->when($buscar, function ($query) use ($buscar) {
                $query->where('nombre', 'like', '%' . $buscar . '%')
                      ->orWhere('codigo', 'like', '%' . $buscar . '%')
                      ->orWhere('marca', 'like', '%' . $buscar . '%')
                      ->orWhere('modelo', 'like', '%' . $buscar . '%');
            })
            ->get();

        return view('admin.productos.index', compact('productos', 'buscar'));
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
}
