<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
})->name('home');


//rutas para el admin
Route::get('/dashboard', function (){ return redirect()->route('admin.index'); })->name('dashboard')->middleware('auth');


Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index')->middleware('auth');

// Rutas para roles
Route::get('/admin/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('admin.roles.index')->middleware(['auth', 'permission:Listado de Roles']);
Route::get('/admin/roles/create', [App\Http\Controllers\RoleController::class, 'create'])->name('admin.roles.create')->middleware(['auth', 'permission:Crear Rol']);
Route::post('/admin/roles/create', [App\Http\Controllers\RoleController::class, 'store'])->name('admin.roles.store')->middleware(['auth', 'permission:Crear Rol']);
Route::get('/admin/rol/{id}', [App\Http\Controllers\RoleController::class, 'show'])->name('admin.roles.show')->middleware(['auth', 'permission:Ver Rol']);
Route::get('/admin/rol/{id}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->name('admin.roles.edit')->middleware(['auth', 'permission:Editar Rol']);
Route::get('/admin/rol/{id}/permisos', [App\Http\Controllers\RoleController::class, 'editPermisos'])->name('admin.roles.permisos.edit')->middleware(['auth', 'permission:Editar Rol']);
Route::put('/admin/rol/{id}/permisos', [App\Http\Controllers\RoleController::class, 'updatePermisos'])->name('admin.roles.permisos.update')->middleware(['auth', 'permission:Editar Rol']);
Route::put('/admin/rol/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('admin.roles.update')->middleware(['auth', 'permission:Editar Rol']);
Route::delete('/admin/rol/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('admin.roles.destroy')->middleware(['auth', 'permission:Eliminar Rol']);

// Rutas para usuarios
Route::get('/admin/usuarios', [App\Http\Controllers\UsuarioController::class, 'index'])->name('admin.usuarios.index')->middleware(['auth', 'permission:Listado de Usuarios']);
Route::get('/admin/usuarios/create', [App\Http\Controllers\UsuarioController::class, 'create'])->name('admin.usuarios.create')->middleware(['auth', 'permission:Crear Usuario']);
Route::post('/admin/usuarios', [App\Http\Controllers\UsuarioController::class, 'store'])->name('admin.usuarios.store')->middleware(['auth', 'permission:Crear Usuario']);
Route::post('/admin/usuario/{id}/restaurar', [App\Http\Controllers\UsuarioController::class, 'restaurar'])->name('admin.usuarios.restaurar')->middleware(['auth', 'permission:Restaurar Usuario']);
Route::get('/admin/usuario/{id}', [App\Http\Controllers\UsuarioController::class, 'show'])->name('admin.usuarios.show')->middleware(['auth', 'permission:Ver Usuario']);
Route::get('/admin/usuario/{id}/edit', [App\Http\Controllers\UsuarioController::class, 'edit'])->name('admin.usuarios.edit')->middleware(['auth', 'permission:Editar Usuario']);
Route::put('/admin/usuario/{id}', [App\Http\Controllers\UsuarioController::class, 'update'])->name('admin.usuarios.update')->middleware(['auth', 'permission:Editar Usuario']);
Route::delete('/admin/usuario/{id}', [App\Http\Controllers\UsuarioController::class, 'destroy'])->name('admin.usuarios.destroy')->middleware(['auth', 'permission:Eliminar Usuario']);

// Rutas para Categorías
Route::get('/admin/categorias', [App\Http\Controllers\CategoriaController::class, 'index'])->name('admin.categorias.index')->middleware(['auth', 'permission:Listado de Categorías']);
Route::get('/admin/categorias/create', [App\Http\Controllers\CategoriaController::class, 'create'])->name('admin.categorias.create')->middleware(['auth', 'permission:Crear Categoría']);
Route::post('/admin/categorias', [App\Http\Controllers\CategoriaController::class, 'store'])->name('admin.categorias.store')->middleware(['auth', 'permission:Crear Categoría']);
Route::post('/admin/categoria/{id}/restaurar', [App\Http\Controllers\CategoriaController::class, 'restaurar'])->name('admin.categorias.restaurar')->middleware(['auth', 'permission:Restaurar Categoría']);
Route::get('/admin/categoria/{id}', [App\Http\Controllers\CategoriaController::class, 'show'])->name('admin.categorias.show')->middleware(['auth', 'permission:Ver Categoría']);
Route::get('/admin/categoria/{id}/edit', [App\Http\Controllers\CategoriaController::class, 'edit'])->name('admin.categorias.edit')->middleware(['auth', 'permission:Editar Categoría']);
Route::put('/admin/categoria/{id}', [App\Http\Controllers\CategoriaController::class, 'update'])->name('admin.categorias.update')->middleware(['auth', 'permission:Editar Categoría']);
Route::delete('/admin/categoria/{id}', [App\Http\Controllers\CategoriaController::class, 'destroy'])->name('admin.categorias.destroy')->middleware(['auth', 'permission:Eliminar Categoría']);

// Rutas para Productos
Route::get('/admin/productos', [App\Http\Controllers\ProductoController::class, 'index'])->name('admin.productos.index')->middleware(['auth', 'permission:Listado de Productos']);
Route::get('/admin/productos/create', [App\Http\Controllers\ProductoController::class, 'create'])->name('admin.productos.create')->middleware(['auth', 'permission:Crear Producto']);
Route::post('/admin/productos', [App\Http\Controllers\ProductoController::class, 'store'])->name('admin.productos.store')->middleware(['auth', 'permission:Crear Producto']);
// Ruta AJAX para Yajra DataTables de Productos (requiere permiso de listado)
Route::get('/admin/productos/data', [App\Http\Controllers\ProductoController::class, 'getProductos'])->name('admin.productos.data')->middleware(['auth', 'permission:Listado de Productos']);
Route::post('/admin/producto/{id}/restaurar', [App\Http\Controllers\ProductoController::class, 'restaurar'])->name('admin.productos.restaurar')->middleware(['auth', 'permission:Restaurar Producto']);
Route::get('/admin/producto/{id}', [App\Http\Controllers\ProductoController::class, 'show'])->name('admin.productos.show')->middleware(['auth', 'permission:Ver Producto']);
Route::get('/admin/producto/{id}/edit', [App\Http\Controllers\ProductoController::class, 'edit'])->name('admin.productos.edit')->middleware(['auth', 'permission:Editar Producto']);
Route::put('/admin/producto/{id}', [App\Http\Controllers\ProductoController::class, 'update'])->name('admin.productos.update')->middleware(['auth', 'permission:Editar Producto']);
Route::delete('/admin/producto/{id}', [App\Http\Controllers\ProductoController::class, 'destroy'])->name('admin.productos.destroy')->middleware(['auth', 'permission:Eliminar Producto']);


require __DIR__.'/settings.php';
