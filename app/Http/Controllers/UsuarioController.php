<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');
        $usuarios = User::query();

        $usuarios = User::withTrashed()
                  ->when($buscar, function ($query) use ($buscar) {
                      $query->where('name', 'like', '%' . $buscar . '%')
                            ->orWhere('email', 'like', '%' . $buscar . '%');
                  })
                  ->paginate(10)
                  ->withQueryString();

    return view('admin.usuarios.index', compact('usuarios', 'buscar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mostrar todos los roles excepto SUPER ADMIN
        $roles = Role::where('name', '!=', 'SUPER ADMIN')->get();

        return view('admin.usuarios.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validación de los datos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'tipo_documento' => 'required|in:cedula de identidad,Pasaporte',
            'numero_documento' => 'required|string|unique:users,numero_documento',
            'celular' => 'required|string',
            'direccion' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|in:Masculino,Femenino',
            'estado' => 'required|in:Activo,Inactivo',
            'foto_perfil' => 'nullable|image|max:2048', // Max 2MB
            'rol' => [
                'required',
                'string',
                Rule::exists('roles', 'name')
                    ->where('guard_name', 'web'),
                Rule::notIn(['SUPER ADMIN']),
            ],
        ]);

        // 2. Manejo de la foto
        if ($request->hasFile('foto_perfil')) {
            $path = $request->file('foto_perfil')->store('usuarios', 'public');
            $validated['foto_perfil'] = $path;
        }

        // 3. Crear usuario (Hashear contraseña)
        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);

        // 4. Asignar rol (Spatie)
        $user->assignRole($request->rol);

        return redirect()->route('admin.usuarios.index')->with([
            'mensaje' => 'Usuario registrado con éxito',
            'icono'   => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $usuario = User::withTrashed()->findOrFail($id);
        return view('admin.usuarios.show', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $usuario = User::findOrFail($id);

        // Solo SUPER ADMIN puede editar cuentas SUPER ADMIN.
        if (
            $usuario->hasRole('SUPER ADMIN') &&
            !auth()->user()->hasRole('SUPER ADMIN')
        ) {
            abort(403, 'No tienes autorización para editar este usuario.');
        }

        // Obtener únicamente roles del guard web.
        if ($usuario->hasRole('SUPER ADMIN')) {
            $roles = Role::where('guard_name', 'web')
                ->where('name', 'SUPER ADMIN')
                ->get();
        } else {
            $roles = Role::where('guard_name', 'web')
                ->where('name', '!=', 'SUPER ADMIN')
                ->get();
        }

        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $usuario = User::findOrFail($id);

        // Solo SUPER ADMIN puede modificar cuentas SUPER ADMIN.
        if (
            $usuario->hasRole('SUPER ADMIN') &&
            !auth()->user()->hasRole('SUPER ADMIN')
        ) {
            abort(403, 'No tienes autorización para modificar este usuario.');
        }

        // 1. Validaciones
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'rol' => $usuario->hasRole('SUPER ADMIN')
                ? ['nullable', Rule::in(['SUPER ADMIN'])]
                : [
                    'required',
                    'string',
                    Rule::exists('roles', 'name')
                        ->where('guard_name', 'web'),
                    Rule::notIn(['SUPER ADMIN']),
                ],
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tipo_documento' => 'required',
            'numero_documento' => [
                'required',
                'string',
                Rule::unique('users', 'numero_documento')
                    ->ignore($usuario->id),
            ],
            'celular' => 'required',
            'direccion' => 'required',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required',
            'estado' => $usuario->hasRole('SUPER ADMIN')
                ? ['nullable', Rule::in([$usuario->estado])]
                : ['required', Rule::in(['Activo', 'Inactivo'])],
            // Validamos la contraseña solo si el usuario decide cambiarla
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // 2. Manejo de la foto
        if ($request->hasFile('foto_perfil')) {
            if ($usuario->foto_perfil) {
                Storage::disk('public')->delete($usuario->foto_perfil);
            }
            $path = $request->file('foto_perfil')->store('usuarios', 'public');
            $usuario->foto_perfil = $path;
        }

        // 3. Actualizar datos (Incluimos la foto si fue actualizada)
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->tipo_documento = $request->tipo_documento;
        $usuario->numero_documento = $request->numero_documento;
        $usuario->celular = $request->celular;
        $usuario->direccion = $request->direccion;
        $usuario->fecha_nacimiento = $request->fecha_nacimiento;
        $usuario->genero = $request->genero;
        if (!$usuario->hasRole('SUPER ADMIN')) {
            $usuario->estado = $request->estado;
        }

        // Solo actualizar contraseña si viene en el request
        if ($request->filled('password')) {
            $usuario->password = bcrypt($request->password);
        }

        $usuario->save();

        // 4. Sincronizar rol
        if (!$usuario->hasRole('SUPER ADMIN')) {
            $usuario->syncRoles([$request->rol]);
        }

        return redirect()->route('admin.usuarios.index')->with([
            'mensaje' => 'Usuario actualizado correctamente',
            'icono' => 'success'
        ]);
    }

    public function restaurar($id)
    {
        // Buscar al usuario, incluyendo eliminados lógicamente.
        $usuario = User::withTrashed()->findOrFail($id);

        // Solo SUPER ADMIN puede restaurar cuentas SUPER ADMIN.
        if (
            $usuario->hasRole('SUPER ADMIN') &&
            !auth()->user()->hasRole('SUPER ADMIN')
        ) {
            abort(403, 'No tienes autorización para restaurar este usuario.');
        }

        // Verificar que realmente esté eliminado.
        if (!$usuario->trashed()) {
            return redirect()->route('admin.usuarios.index')->with([
                'mensaje' => 'El usuario ya se encuentra activo en el sistema.',
                'icono' => 'warning',
            ]);
        }

        // Restaurar usuario.
        $usuario->restore();

        return redirect()->route('admin.usuarios.index')->with([
            'mensaje' => 'Usuario restaurado correctamente.',
            'icono' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = User::findOrFail($id);

        // Impedir que un usuario elimine su propia cuenta.
        if ($usuario->id === auth()->id()) {
            return redirect()->route('admin.usuarios.index')->with([
                'mensaje' => 'No puedes eliminar tu propia cuenta.',
                'icono' => 'warning',
            ]);
        }

        // Proteger las cuentas SUPER ADMIN.
        if ($usuario->hasRole('SUPER ADMIN')) {
            return redirect()->route('admin.usuarios.index')->with([
                'mensaje' => 'No puedes eliminar una cuenta SUPER ADMIN.',
                'icono' => 'error',
            ]);
        }

        // Eliminación lógica mediante Soft Deletes.
        $usuario->delete();

        return redirect()->route('admin.usuarios.index')->with([
            'mensaje' => 'Usuario eliminado correctamente.',
            'icono' => 'success',
        ]);
    }
}
