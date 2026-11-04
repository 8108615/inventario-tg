<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');
        $roles = Role::query();

        $roles = Role::where('name', 'like', '%' . $buscar . '%')
                  ->paginate(10)
                  ->withQueryString();

        return view('admin.roles.index', compact('roles', 'buscar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        $rol = new Role();
        $rol->name = $request->name;
        $rol->save();

        return redirect()->route('admin.roles.index')
            ->with('mensaje', 'Rol guardado correctamente')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rol = Role::find($id);
        return view('admin.roles.show', compact('rol'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rol = Role::find($id);
        return view('admin.roles.edit', compact('rol'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $rol = Role::findOrFail($id);

        // Proteger el nombre del rol SUPER ADMIN
        if ($rol->name === 'SUPER ADMIN') {
            return redirect()->route('admin.roles.index')
                ->with('mensaje', 'El rol SUPER ADMIN está protegido y no puede modificarse.')
                ->with('icono', 'warning');
        }

        // Validar el nombre del rol
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:roles,name,' . $rol->id,
                'not_in:SUPER ADMIN',
            ],
        ]);

        // Actualizar el rol
        $rol->name = $request->name;
        $rol->save();

        return redirect()->route('admin.roles.index')
            ->with('mensaje', 'Rol actualizado correctamente.')
            ->with('icono', 'success');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rol = Role::findOrFail($id);

        // Proteger el rol SUPER ADMIN
        if ($rol->name === 'SUPER ADMIN') {
            return redirect()->route('admin.roles.index')
                ->with('mensaje', 'El rol SUPER ADMIN está protegido y no puede eliminarse.')
                ->with('icono', 'warning');
        }

        // Evitar eliminar roles que tienen usuarios asignados
        if ($rol->users()->exists()) {
            return redirect()->route('admin.roles.index')
                ->with('mensaje', 'No se puede eliminar este rol porque tiene usuarios asignados.')
                ->with('icono', 'warning');
        }

        // Eliminar rol
        $rol->delete();

        return redirect()->route('admin.roles.index')
            ->with('mensaje', 'Rol eliminado correctamente.')
            ->with('icono', 'success');
    }

    // Mostrar vista para asignar permisos a un rol específico
    public function editPermisos(string $id)
    {
        $rol = Role::findOrFail($id);
        $permisos = Permission::all();
        $permisoRol = $rol->permissions->pluck('name')->toArray();

        return view('admin.roles.permisos', compact('rol', 'permisos', 'permisoRol'));
    }

    // Actualizar los permisos seleccionados para el rol
    public function updatePermisos(Request $request, string $id)
    {
        $rol = Role::findOrFail($id);

        // Proteger los permisos del SUPER ADMIN
        if ($rol->name === 'SUPER ADMIN') {
            return redirect()->route('admin.roles.index')
                ->with('mensaje', 'Los permisos del rol SUPER ADMIN están protegidos y no pueden modificarse.')
                ->with('icono', 'warning');
        }

        // Validar que los permisos existan en la base de datos
        $datos = $request->validate([
            'permisos' => ['nullable', 'array'],
            'permisos.*' => [
                'required',
                'string',
                'distinct',
                \Illuminate\Validation\Rule::exists('permissions', 'name')
                    ->where('guard_name', $rol->guard_name),
            ],
        ]);

        // Actualizar los permisos del rol
        $rol->syncPermissions($datos['permisos'] ?? []);

        return redirect()->route('admin.roles.index')
            ->with('mensaje', 'Permisos actualizados correctamente para el rol ' . $rol->name)
            ->with('icono', 'success');
    }
}
