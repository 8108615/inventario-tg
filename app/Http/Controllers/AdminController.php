<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // ========================================
        // ESTADÍSTICAS GENERALES DE PRODUCTOS
        // ========================================

        // Total de productos registrados,
        // incluyendo los eliminados lógicamente.
        $totalProductos = Producto::withTrashed()->count();

        // Productos activos que no están eliminados.
        $productosActivos = Producto::where('estado', 'Activo')
            ->count();

        // Productos inactivos:
        // Incluye estado Inactivo y eliminados lógicamente.
        $productosInactivos = Producto::withTrashed()
            ->where(function ($query) {
                $query->where('estado', 'Inactivo')
                    ->orWhereNotNull('deleted_at');
            })
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
