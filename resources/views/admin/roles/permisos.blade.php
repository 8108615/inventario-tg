<x-layouts::app title="Asignar Permisos al Rol">
    <div class="relative mb-6 w-full flex justify-between items-center">
        <div>
            <flux:heading size="xl" level="1">Asignar Permisos al Rol: <span class="text-blue-500">{{ $rol->name }}</span></flux:heading>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Selecciona los permisos que tendrá este rol por cada módulo del sistema.</p>
        </div>

        <a href="{{ route('admin.roles.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold text-sm rounded-lg transition shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver al Listado
        </a>
    </div>
    <flux:separator variant="subtle" class="mb-6" />

    <form action="{{ route('admin.roles.permisos.update', $rol->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            @php
                $modulosPermisos = [
                    'Módulo Usuarios' => $permisos->filter(function($p) { return str_contains($p->name, 'Usuario'); }),
                    'Módulo Roles' => $permisos->filter(function($p) { return str_contains($p->name, 'Rol'); }),
                    'Módulo Categorías' => $permisos->filter(function($p) { return str_contains($p->name, 'Categoría'); }),
                    'Módulo Productos' => $permisos->filter(function($p) { return str_contains($p->name, 'Producto'); }),
                ];
            @endphp

            @foreach($modulosPermisos as $nombreModulo => $listaPermisos)
                <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg p-5 shadow-sm">
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-200 dark:border-zinc-700">
                        <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 uppercase tracking-wider">{{ $nombreModulo }}</h3>
                        <span class="text-xs px-2.5 py-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 rounded-full font-semibold">
                            {{ $listaPermisos->count() }} permisos
                        </span>
                    </div>

                    <div class="space-y-3">
                        @foreach($listaPermisos as $permiso)
                            <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-700/50 transition cursor-pointer">
                                <input type="checkbox" name="permisos[]" value="{{ $permiso->name }}"
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-zinc-600 rounded bg-gray-50 dark:bg-zinc-900"
                                       {{ in_array($permiso->name, $permisoRol) ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $permiso->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Botones de Acción -->
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-zinc-700">
            <a href="{{ route('admin.roles.index') }}"
               class="px-5 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition shadow-sm">
                Cancelar
            </a>
            <button type="submit"
                    class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-sm cursor-pointer">
                Guardar Permisos
            </button>
        </div>
    </form>
</x-layouts::app>
