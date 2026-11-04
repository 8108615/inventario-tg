
<x-layouts::app :title="'Gestión de Permisos - ' . $rol->name">

    @php
        $esSuperAdmin = $rol->name === 'SUPER ADMIN';

        $modulos = [
            [
                'nombre' => 'Usuarios',
                'descripcion' => 'Gestión de usuarios y accesos',
                'icono' => 'fa-users',
                'palabra' => 'Usuario',
            ],
            [
                'nombre' => 'Roles',
                'descripcion' => 'Administración de roles y privilegios',
                'icono' => 'fa-user-shield',
                'palabra' => 'Rol',
            ],
            [
                'nombre' => 'Categorías',
                'descripcion' => 'Organización de categorías',
                'icono' => 'fa-tags',
                'palabra' => 'Categoría',
            ],
            [
                'nombre' => 'Productos',
                'descripcion' => 'Gestión del inventario',
                'icono' => 'fa-box',
                'palabra' => 'Producto',
            ],
        ];
    @endphp

    <div class="w-full space-y-5">

        <!-- ENCABEZADO PRINCIPAL -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-500">
                    <i class="fas fa-shield-alt"></i>
                    THE GAME SRL / SEGURIDAD
                </p>

                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">
                    Gestión de permisos:
                    <span class="text-blue-500">{{ $rol->name }}</span>
                </h1>

                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                    Administra los permisos y niveles de acceso de cada rol del sistema.
                </p>
            </div>

            <a href="{{ route('admin.roles.index') }}"
               class="inline-flex items-center justify-center gap-2 rounded-lg border border-zinc-300 px-4 py-2.5 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-white dark:hover:bg-zinc-800">

                <i class="fas fa-arrow-left"></i>
                Volver al listado

            </a>

        </div>

        <flux:separator variant="subtle" />

        <!-- FORMULARIO -->
        <form
            id="formPermisos"
            action="{{ route('admin.roles.permisos.update', $rol->id) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <!-- HERRAMIENTAS DE SELECCIÓN -->
            <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h2 class="text-sm font-bold text-zinc-900 dark:text-white">
                        Configuración de accesos
                    </h2>

                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                        Selecciona las acciones permitidas para este rol.
                    </p>
                </div>

                @if (!$esSuperAdmin)
                    <div class="flex flex-wrap items-center gap-2">

                        <button
                            type="button"
                            id="seleccionarTodos"
                            class="inline-flex items-center gap-2 rounded-lg border border-blue-500/30 bg-blue-500/10 px-3 py-2 text-xs font-semibold text-blue-500 transition hover:bg-blue-500/20"
                        >
                            <i class="fas fa-check-double"></i>
                            Seleccionar todos
                        </button>

                        <button
                            type="button"
                            id="quitarTodos"
                            class="inline-flex items-center gap-2 rounded-lg border border-zinc-300 px-3 py-2 text-xs font-semibold text-zinc-600 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800"
                        >
                            <i class="fas fa-times"></i>
                            Quitar todos
                        </button>

                    </div>
                @endif

            </div>

            <!-- TARJETAS DE MÓDULOS -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

                @foreach ($modulos as $indice => $modulo)

                    @php
                        $listaPermisos = $permisos->filter(function ($permiso) use ($modulo) {
                            return str_contains($permiso->name, $modulo['palabra']);
                        });

                        $totalModulo = $listaPermisos->count();

                        $asignadosModulo = $listaPermisos->filter(function ($permiso) use ($permisoRol) {
                            return in_array($permiso->name, $permisoRol);
                        })->count();

                        $porcentaje = $totalModulo > 0
                            ? ($asignadosModulo / $totalModulo) * 100
                            : 0;
                    @endphp

                    <div
                        class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm transition hover:border-blue-500/40 dark:border-zinc-700 dark:bg-zinc-800/70"
                        data-modulo="{{ $indice }}"
                    >

                        <!-- ENCABEZADO DEL MÓDULO -->
                        <div class="border-b border-zinc-200 bg-zinc-50/80 p-4 dark:border-zinc-700 dark:bg-zinc-900/40">

                            <div class="flex items-center justify-between gap-3">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg border border-blue-500/20 bg-blue-500/10 text-blue-500">
                                        <i class="fas {{ $modulo['icono'] }} text-base"></i>
                                    </div>

                                    <div>
                                        <h3 class="text-sm font-bold text-zinc-900 dark:text-white">
                                            Módulo {{ $modulo['nombre'] }}
                                        </h3>

                                        <p class="mt-0.5 text-xs text-zinc-500 dark:text-zinc-400">
                                            {{ $modulo['descripcion'] }}
                                        </p>
                                    </div>

                                </div>

                                <span
                                    class="contador-modulo rounded-full border border-blue-500/20 bg-blue-500/10 px-2.5 py-1 text-xs font-bold text-blue-500"
                                >
                                    {{ $asignadosModulo }}/{{ $totalModulo }}
                                </span>

                            </div>

                            <!-- BARRA DE PROGRESO -->
                            <div class="mt-3 h-1.5 w-full overflow-hidden rounded-full bg-zinc-200 dark:bg-zinc-700">

                                <div
                                    class="barra-progreso h-full rounded-full bg-blue-500 transition-all duration-300"
                                    style="width: {{ $porcentaje }}%"
                                ></div>

                            </div>

                        </div>

                        <!-- LISTADO DE PERMISOS -->
                        <div class="space-y-0.5 p-3 sm:p-4">

                            <!-- SELECCIONAR MÓDULO -->
                            @if (!$esSuperAdmin)

                                <label
                                    class="mb-2 flex cursor-pointer items-center justify-between gap-2 rounded-lg border border-blue-500/20 bg-blue-500/5 px-3 py-2 transition hover:bg-blue-500/10"
                                >

                                    <span class="flex items-center gap-2 text-xs font-semibold text-blue-500">
                                        <i class="fas fa-list-check"></i>
                                        Seleccionar todo el módulo
                                    </span>

                                    <input
                                        type="checkbox"
                                        class="checkbox-modulo h-4 w-4 cursor-pointer rounded border-zinc-500 text-blue-600 focus:ring-blue-500"
                                        data-modulo="{{ $indice }}"
                                    >

                                </label>

                            @endif

                            @forelse ($listaPermisos as $permiso)

                                <label
                                    class="flex cursor-pointer items-center gap-3 rounded-lg border border-transparent px-3 py-1.5 transition hover:border-zinc-200 hover:bg-zinc-50 dark:hover:border-zinc-700 dark:hover:bg-zinc-700/40"
                                >

                                    <input
                                        type="checkbox"
                                        name="permisos[]"
                                        value="{{ $permiso->name }}"
                                        class="checkbox-permiso h-4 w-4 cursor-pointer rounded border-zinc-500 text-blue-600 focus:ring-blue-500"
                                        data-modulo="{{ $indice }}"
                                        {{ in_array($permiso->name, $permisoRol) ? 'checked' : '' }}
                                        {{ $esSuperAdmin ? 'disabled' : '' }}
                                    >

                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-200">
                                        {{ $permiso->name }}
                                    </span>

                                </label>

                            @empty

                                <p class="py-3 text-center text-sm text-zinc-500">
                                    No hay permisos registrados en este módulo.
                                </p>

                            @endforelse

                        </div>

                    </div>

                @endforeach

            </div>

            <!-- BOTONES INFERIORES -->
            <div class="mt-6 flex flex-col gap-3 border-t border-zinc-200 pt-5 dark:border-zinc-700 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400">
                    <i class="fas fa-shield-alt text-blue-500"></i>

                    <span>
                        <strong id="totalSeleccionados" class="text-blue-500">0</strong>
                        permisos seleccionados
                    </span>
                </div>

                <div class="flex flex-wrap items-center justify-end gap-3">

                    <a
                        href="{{ route('admin.roles.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-zinc-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-600"
                    >
                        <i class="fas fa-times"></i>
                        Cancelar
                    </a>

                    @if (!$esSuperAdmin)

                        <button
                            type="submit"
                            id="guardarPermisos"
                            class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                        >
                            <i class="fas fa-save"></i>
                            Guardar permisos
                        </button>

                    @endif

                </div>

            </div>

        </form>

    </div>

    <!-- JAVASCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const permisos = document.querySelectorAll('.checkbox-permiso');
            const modulos = document.querySelectorAll('.checkbox-modulo');
            const tarjetas = document.querySelectorAll('[data-modulo].rounded-xl');

            const totalSeleccionados = document.getElementById('totalSeleccionados');

            function actualizarContadores() {

                let total = 0;

                permisos.forEach(function (checkbox) {
                    if (checkbox.checked) {
                        total++;
                    }
                });

                if (totalSeleccionados) {
                    totalSeleccionados.textContent = total;
                }

                tarjetas.forEach(function (tarjeta) {

                    const lista = tarjeta.querySelectorAll('.checkbox-permiso');

                    const seleccionados = Array.from(lista).filter(function (checkbox) {
                        return checkbox.checked;
                    }).length;

                    const contador = tarjeta.querySelector('.contador-modulo');
                    const barra = tarjeta.querySelector('.barra-progreso');
                    const checkboxModulo = tarjeta.querySelector('.checkbox-modulo');

                    if (contador) {
                        contador.textContent = seleccionados + '/' + lista.length;
                    }

                    if (barra) {
                        const porcentaje = lista.length > 0
                            ? (seleccionados / lista.length) * 100
                            : 0;

                        barra.style.width = porcentaje + '%';
                    }

                    if (checkboxModulo) {
                        checkboxModulo.checked = lista.length > 0 &&
                            seleccionados === lista.length;

                        checkboxModulo.indeterminate =
                            seleccionados > 0 && seleccionados < lista.length;
                    }

                });

            }

            // Seleccionar todos los permisos de un módulo
            modulos.forEach(function (checkboxModulo) {

                checkboxModulo.addEventListener('change', function () {

                    const modulo = this.dataset.modulo;

                    permisos.forEach(function (checkbox) {

                        if (checkbox.dataset.modulo === modulo && !checkbox.disabled) {
                            checkbox.checked = checkboxModulo.checked;
                        }

                    });

                    actualizarContadores();

                });

            });

            // Actualizar al seleccionar individualmente
            permisos.forEach(function (checkbox) {

                checkbox.addEventListener('change', actualizarContadores);

            });

            // Seleccionar todos los permisos
            const seleccionarTodos = document.getElementById('seleccionarTodos');

            if (seleccionarTodos) {

                seleccionarTodos.addEventListener('click', function () {

                    permisos.forEach(function (checkbox) {

                        if (!checkbox.disabled) {
                            checkbox.checked = true;
                        }

                    });

                    actualizarContadores();

                });

            }

            // Quitar todos los permisos
            const quitarTodos = document.getElementById('quitarTodos');

            if (quitarTodos) {

                quitarTodos.addEventListener('click', function () {

                    permisos.forEach(function (checkbox) {

                        if (!checkbox.disabled) {
                            checkbox.checked = false;
                        }

                    });

                    actualizarContadores();

                });

            }

            // Confirmación antes de guardar
            const formulario = document.getElementById('formPermisos');

            if (formulario) {

                formulario.addEventListener('submit', function (event) {

                    event.preventDefault();

                    if (typeof Swal === 'undefined') {

                        if (confirm('¿Desea guardar los cambios en los permisos?')) {
                            formulario.submit();
                        }

                        return;
                    }

                    Swal.fire({
                        title: '¿Guardar permisos?',
                        text: 'Se actualizarán los permisos asignados a este rol.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, guardar',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#2563eb',
                        cancelButtonColor: '#52525b',
                        reverseButtons: true
                    }).then(function (resultado) {

                        if (resultado.isConfirmed) {
                            formulario.submit();
                        }

                    });

                });

            }

            actualizarContadores();

        });
    </script>

</x-layouts::app>
