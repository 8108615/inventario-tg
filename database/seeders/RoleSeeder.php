<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar caché de permisos de Spatie
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Definir los permisos limpios agrupados por módulo
        $modulos = [
            'Usuarios' => ['Listado de Usuarios', 'Ver Usuario', 'Crear Usuario', 'Editar Usuario', 'Eliminar Usuario', 'Restaurar Usuario'],
            'Roles' => ['Listado de Roles', 'Ver Rol', 'Crear Rol', 'Editar Rol', 'Eliminar Rol'],
            'Categorias' => ['Listado de Categorías', 'Ver Categoría', 'Crear Categoría', 'Editar Categoría', 'Eliminar Categoría', 'Restaurar Categoría'],
            'Productos' => ['Listado de Productos', 'Ver Producto', 'Crear Producto', 'Editar Producto', 'Eliminar Producto', 'Restaurar Producto'],
        ];

        foreach ($modulos as $modulo => $acciones) {
            foreach ($acciones as $accion) {
                Permission::firstOrCreate(['name' => $accion, 'guard_name' => 'web']);
            }
        }

        // Crear Roles principales
        $roleSuperAdmin = Role::firstOrCreate(['name' => 'SUPER ADMIN', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'ADMINISTRADOR', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'EDITOR', 'guard_name' => 'web']);

        // El Super Admin obtiene todos los permisos automáticamente por defecto
        $roleSuperAdmin->givePermissionTo(Permission::all());
    }
}
