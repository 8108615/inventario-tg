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
        // VERIFICAR PERMISOS DEL USUARIO
        // ========================================

        $usuario = auth()->user();

        $puedeVerProductos = $usuario->can('Listado de Productos');
        $puedeVerCategorias = $usuario->can('Listado de Categorías');
        $puedeVerUsuarios = $usuario->can('Listado de Usuarios');

        // ========================================
        // INICIALIZAR ESTADÍSTICAS
        // ========================================

        $totalProductos = null;
        $productosActivos = null;
        $productosInactivos = null;

        $totalCategorias = null;
        $categoriasActivas = null;

        $totalUsuarios = null;
        $usuariosActivos = null;
        $usuariosInactivos = null;

        $productosPorCategoria = collect();
        $maxProductosCategoria = 1;

        // ========================================
        // ESTADÍSTICAS DE PRODUCTOS
        // ========================================

        if ($puedeVerProductos) {

            $estadisticas = Producto::withTrashed()
                ->selectRaw("
                    COUNT(*) AS total,
                    COALESCE(SUM(
                        CASE
                            WHEN estado = 'Activo'
                             AND deleted_at IS NULL
                            THEN 1 ELSE 0
                        END
                    ), 0) AS activos,
                    COALESCE(SUM(
                        CASE
                            WHEN estado = 'Inactivo'
                              OR deleted_at IS NOT NULL
                            THEN 1 ELSE 0
                        END
                    ), 0) AS inactivos
                ")
                ->first();

            $totalProductos = (int) $estadisticas->total;
            $productosActivos = (int) $estadisticas->activos;
            $productosInactivos = (int) $estadisticas->inactivos;
        }

        // ========================================
        // ESTADÍSTICAS DE CATEGORÍAS
        // ========================================

        if ($puedeVerCategorias) {

            $estadisticas = Categoria::query()
                ->selectRaw("
                    COUNT(*) AS total,
                    COALESCE(SUM(
                        CASE
                            WHEN estado = 'Activo'
                            THEN 1 ELSE 0
                        END
                    ), 0) AS activos
                ")
                ->first();

            $totalCategorias = (int) $estadisticas->total;
            $categoriasActivas = (int) $estadisticas->activos;
        }

        // ========================================
        // ESTADÍSTICAS DE USUARIOS
        // ========================================

        if ($puedeVerUsuarios) {

            $estadisticas = User::query()
                ->selectRaw("
                    COUNT(*) AS total,
                    COALESCE(SUM(
                        CASE
                            WHEN estado = 'Activo'
                            THEN 1 ELSE 0
                        END
                    ), 0) AS activos,
                    COALESCE(SUM(
                        CASE
                            WHEN estado = 'Inactivo'
                            THEN 1 ELSE 0
                        END
                    ), 0) AS inactivos
                ")
                ->first();

            $totalUsuarios = (int) $estadisticas->total;
            $usuariosActivos = (int) $estadisticas->activos;
            $usuariosInactivos = (int) $estadisticas->inactivos;
        }

        // ========================================
        // PRODUCTOS POR CATEGORÍA
        // ========================================

        if ($puedeVerProductos && $puedeVerCategorias) {

            $productosPorCategoria = Categoria::query()
                ->where('estado', 'Activo')
                ->withCount('productos')
                ->orderByDesc('productos_count')
                ->take(6)
                ->get();

            $maxProductosCategoria = max(
                1,
                (int) $productosPorCategoria->max('productos_count')
            );
        }

        // ========================================
        // MOSTRAR DASHBOARD
        // ========================================

        return view('admin.index', compact(
            'puedeVerProductos',
            'puedeVerCategorias',
            'puedeVerUsuarios',
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
