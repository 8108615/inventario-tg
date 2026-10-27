<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

//rutas para el admin
Route::get('/dashboard', function (){ return redirect()->route('admin.index'); })->name('dashboard')->middleware('auth');


Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index')->middleware('auth');

//Rutas para roles
Route::get('/admin/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('admin.roles.index')->middleware('auth');
Route::get('/admin/roles/create', [App\Http\Controllers\RoleController::class, 'create'])->name('admin.roles.create')->middleware('auth');
Route::post('/admin/roles/create', [App\Http\Controllers\RoleController::class, 'store'])->name('admin.roles.store')->middleware('auth');
Route::get('/admin/rol/{id}', [App\Http\Controllers\RoleController::class, 'show'])->name('admin.roles.show')->middleware('auth');
Route::get('/admin/rol/{id}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->name('admin.roles.edit')->middleware('auth');
//Route::get('/admin/rol/{id}/permisos', [App\Http\Controllers\RoleController::class, 'permisos'])->name('admin.roles.permisos')->middleware('auth');
//Route::put('/admin/rol/{id}/update_permisos', [App\Http\Controllers\RoleController::class, 'updatePermisos'])->name('admin.roles.updatePermisos')->middleware('auth');
Route::put('/admin/rol/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('admin.roles.update')->middleware('auth');
Route::delete('/admin/rol/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('admin.roles.destroy')->middleware('auth');

//Rutas para usuarios
Route::get('/admin/usuarios', [App\Http\Controllers\UsuarioController::class, 'index'])->name('admin.usuarios.index')->middleware('auth');
Route::get('/admin/usuarios/create', [App\Http\Controllers\UsuarioController::class, 'create'])->name('admin.usuarios.create')->middleware('auth');
Route::post('/admin/usuarios', [App\Http\Controllers\UsuarioController::class, 'store'])->name('admin.usuarios.store')->middleware('auth');
Route::post('/admin/usuario/{id}/restaurar', [App\Http\Controllers\UsuarioController::class, 'restaurar'])->name('admin.usuarios.restaurar')->middleware('auth');
Route::get('/admin/usuario/{id}', [App\Http\Controllers\UsuarioController::class, 'show'])->name('admin.usuarios.show')->middleware('auth');
Route::get('/admin/usuario/{id}/edit', [App\Http\Controllers\UsuarioController::class, 'edit'])->name('admin.usuarios.edit')->middleware('auth');
Route::put('/admin/usuario/{id}', [App\Http\Controllers\UsuarioController::class, 'update'])->name('admin.usuarios.update')->middleware('auth');
Route::delete('/admin/usuario/{id}', [App\Http\Controllers\UsuarioController::class, 'destroy'])->name('admin.usuarios.destroy')->middleware('auth');

require __DIR__.'/settings.php';
