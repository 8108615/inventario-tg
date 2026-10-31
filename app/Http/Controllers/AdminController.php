<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // Estadísticas generales de productos
        $totalProductos = Producto::count();

        $productosActivos = Producto::where('estado', 'Activo')
            ->count();

        $productosInactivos = Producto::where('estado', 'Inactivo')
            ->count();

        // Estadísticas generales de categorías
        $totalCategorias = Categoria::count();

        $categoriasActivas = Categoria::where('estado', 'Activo')
            ->count();

        // Estadísticas generales de usuarios
        $totalUsuarios = User::count();

        $usuariosActivos = User::where('estado', 'Activo')
            ->count();

        $usuariosInactivos = User::where('estado', 'Inactivo')
            ->count();

        // Productos agrupados por categoría para el gráfico
        $productosPorCategoria = Categoria::query()
            ->where('estado', 'Activo')
            ->withCount('productos')
            ->orderByDesc('productos_count')
            ->take(6)
            ->get();

        // Valor máximo para calcular el ancho de las barras
        $maxProductosCategoria = max(
            1,
            (int) $productosPorCategoria->max('productos_count')
        );

        return view('admin.index', compact(
            'totalProductos',
            'productosActivos',
            'productosInactivos',
            'totalCategorias',
            'categoriasActivas',
            'totalUsuarios',
            'usuariosActivos',
            'usuariosInactivos',
            'productosPorCategoria',
            'maxProductosCategoria'
        ));
    }
}
