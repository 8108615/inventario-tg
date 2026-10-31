<x-layouts::app :title="__('Dashboard')">

    <div class="space-y-8 p-4 md:p-6">

        {{-- ENCABEZADO --}}
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

            <div>
                <div class="mb-2 flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-blue-500"></span>

                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-400">
                        THE GAME SRL
                    </span>
                </div>

                <h1 class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-white md:text-3xl">
                    Panel de control
                </h1>

                <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">
                    Bienvenido, {{ auth()->user()->name }}.
                    Aquí tienes el resumen de tu inventario.
                </p>
            </div>

            <div class="flex items-center gap-3 rounded-xl border border-neutral-200 bg-white px-4 py-3 dark:border-neutral-800 dark:bg-neutral-900">

                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-500/10 text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 0 1 1 1v13H4V6a1 1 0 0 1 1-1Z"/>
                    </svg>
                </div>

                <div>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400">
                        Fecha actual
                    </p>

                    <p class="text-sm font-semibold text-neutral-800 dark:text-white">
                        {{ now()->locale('es')->translatedFormat('d M, Y') }}
                    </p>
                </div>

            </div>
        </div>


        {{-- TARJETAS PRINCIPALES --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">

            {{-- TOTAL PRODUCTOS --}}
            <div class="relative overflow-hidden rounded-2xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900">

                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                            Total de productos
                        </p>

                        <h2 class="mt-3 text-3xl font-bold text-neutral-900 dark:text-white">
                            {{ number_format($totalProductos) }}
                        </h2>
                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500/10 text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-6 w-6"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M20 7.5 12 12m0 0L4 7.5M12 12v9m8-13.5v9L12 21l-8-4.5v-9L12 3l8 4.5Z"/>
                        </svg>
                    </div>
                </div>

                <div class="mt-5 flex items-center gap-2 text-xs text-neutral-500 dark:text-neutral-400">
                    <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                    Inventario registrado
                </div>
            </div>


            {{-- PRODUCTOS ACTIVOS --}}
            <div class="relative overflow-hidden rounded-2xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900">

                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                            Productos activos
                        </p>

                        <h2 class="mt-3 text-3xl font-bold text-neutral-900 dark:text-white">
                            {{ number_format($productosActivos) }}
                        </h2>
                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-500">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-6 w-6"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="m5 12 4 4L19 6"/>
                        </svg>
                    </div>
                </div>

                <div class="mt-5 flex items-center gap-2 text-xs text-emerald-500">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    Disponibles en el sistema
                </div>
            </div>


            {{-- PRODUCTOS INACTIVOS --}}
            <div class="relative overflow-hidden rounded-2xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900">

                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                            Productos inactivos
                        </p>

                        <h2 class="mt-3 text-3xl font-bold text-neutral-900 dark:text-white">
                            {{ number_format($productosInactivos) }}
                        </h2>
                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500/10 text-amber-500">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-6 w-6"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <circle cx="12" cy="12" r="9"/>
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M9 9l6 6m0-6-6 6"/>
                        </svg>
                    </div>
                </div>

                <div class="mt-5 flex items-center gap-2 text-xs text-amber-500">
                    <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                    Requieren revisión
                </div>
            </div>


            {{-- CATEGORÍAS --}}
            <div class="relative overflow-hidden rounded-2xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900">

                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                            Categorías
                        </p>

                        <h2 class="mt-3 text-3xl font-bold text-neutral-900 dark:text-white">
                            {{ number_format($totalCategorias) }}
                        </h2>
                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-500/10 text-violet-500">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-6 w-6"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M4 5h6v6H4V5Zm10 0h6v6h-6V5ZM4 15h6v6H4v-6Zm10 0h6v6h-6v-6Z"/>
                        </svg>
                    </div>
                </div>

                <div class="mt-5 flex items-center gap-2 text-xs text-violet-500">
                    <span class="h-2 w-2 rounded-full bg-violet-500"></span>
                    {{ $categoriasActivas }} categorías activas
                </div>
            </div>


            {{-- USUARIOS REGISTRADOS --}}
            <div class="relative overflow-hidden rounded-2xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900">

                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                            Usuarios registrados
                        </p>

                        <h2 class="mt-3 text-3xl font-bold text-neutral-900 dark:text-white">
                            {{ number_format($totalUsuarios) }}
                        </h2>
                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-500/10 text-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-6 w-6"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m6-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm10 10v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                </div>

                <div class="mt-5 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs">
                    <span class="flex items-center gap-1 text-emerald-500">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        {{ $usuariosActivos }} activos
                    </span>

                    <span class="flex items-center gap-1 text-neutral-500 dark:text-neutral-400">
                        <span class="h-2 w-2 rounded-full bg-neutral-400"></span>
                        {{ $usuariosInactivos }} inactivos
                    </span>
                </div>
            </div>

        </div>


        {{-- GRÁFICO Y ACCESOS RÁPIDOS --}}
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

            {{-- PRODUCTOS POR CATEGORÍA --}}
            <div class="rounded-2xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900 xl:col-span-2">

                <div class="flex flex-col justify-between gap-2 sm:flex-row sm:items-center">

                    <div>
                        <h2 class="text-lg font-semibold text-neutral-900 dark:text-white">
                            Productos por categoría
                        </h2>

                        <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                            Distribución de productos en las categorías activas.
                        </p>
                    </div>

                    @can('Listado de Categorías')
                        <a href="{{ route('admin.categorias.index') }}"
                           class="inline-flex items-center gap-2 text-sm font-medium text-blue-500 transition hover:text-blue-400">

                            Ver categorías

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-4 w-4"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M5 12h14m-7-7 7 7-7 7"/>
                            </svg>
                        </a>
                    @endcan

                </div>


                <div class="mt-8 space-y-6">

                    @forelse ($productosPorCategoria as $categoria)

                        @php
                            $porcentaje = ($categoria->productos_count / $maxProductosCategoria) * 100;
                        @endphp

                        <div>

                            <div class="mb-2 flex items-center justify-between gap-4">

                                <span class="truncate text-sm font-medium text-neutral-700 dark:text-neutral-200">
                                    {{ $categoria->nombre }}
                                </span>

                                <span class="shrink-0 text-sm font-semibold text-neutral-900 dark:text-white">
                                    {{ number_format($categoria->productos_count) }}
                                </span>

                            </div>

                            <div class="h-2.5 overflow-hidden rounded-full bg-neutral-100 dark:bg-neutral-800">

                                <div
                                    class="h-full rounded-full bg-blue-500 transition-all duration-500"
                                    style="width: {{ $porcentaje }}%">
                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="rounded-xl border border-dashed border-neutral-300 px-4 py-10 text-center dark:border-neutral-700">

                            <p class="text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                No hay categorías activas para mostrar.
                            </p>

                            <p class="mt-2 text-xs text-neutral-500 dark:text-neutral-400">
                                Registra una categoría y asígnale productos para ver las estadísticas.
                            </p>

                        </div>

                    @endforelse

                </div>

                <p class="mt-6 text-xs text-neutral-500 dark:text-neutral-400">
                    Se muestran hasta seis categorías, ordenadas por cantidad de productos.
                </p>

            </div>


            {{-- ACCESOS RÁPIDOS --}}
            <div class="rounded-2xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900">

                <h2 class="text-lg font-semibold text-neutral-900 dark:text-white">
                    Accesos rápidos
                </h2>

                <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                    Accede directamente a los módulos del sistema.
                </p>


                <div class="mt-6 space-y-3">

                    {{-- PRODUCTOS --}}
                    @can('Listado de Productos')
                        <a href="{{ route('admin.productos.index') }}"
                           class="group flex items-center gap-3 rounded-xl border border-neutral-200 p-3 transition hover:border-blue-500/50 hover:bg-blue-500/5 dark:border-neutral-800">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-blue-500/10 text-blue-500 transition group-hover:bg-blue-500/20">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.8">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M20 7.5 12 12m0 0L4 7.5M12 12v9m8-13.5v9L12 21l-8-4.5v-9L12 3l8 4.5Z"/>
                                </svg>

                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-neutral-800 dark:text-white">
                                    Productos
                                </p>

                                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                                    Gestionar inventario
                                </p>
                            </div>

                            <span class="text-neutral-400 transition group-hover:translate-x-1 group-hover:text-blue-500">
                                →
                            </span>

                        </a>
                    @endcan


                    {{-- CATEGORÍAS --}}
                    @can('Listado de Categorías')
                        <a href="{{ route('admin.categorias.index') }}"
                           class="group flex items-center gap-3 rounded-xl border border-neutral-200 p-3 transition hover:border-violet-500/50 hover:bg-violet-500/5 dark:border-neutral-800">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-violet-500/10 text-violet-500 transition group-hover:bg-violet-500/20">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.8">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M4 5h6v6H4V5Zm10 0h6v6h-6V5ZM4 15h6v6H4v-6Zm10 0h6v6h-6v-6Z"/>
                                </svg>

                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-neutral-800 dark:text-white">
                                    Categorías
                                </p>

                                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                                    Organizar productos
                                </p>
                            </div>

                            <span class="text-neutral-400 transition group-hover:translate-x-1 group-hover:text-violet-500">
                                →
                            </span>

                        </a>
                    @endcan


                    {{-- USUARIOS --}}
                    @can('Listado de Usuarios')
                        <a href="{{ route('admin.usuarios.index') }}"
                           class="group flex items-center gap-3 rounded-xl border border-neutral-200 p-3 transition hover:border-emerald-500/50 hover:bg-emerald-500/5 dark:border-neutral-800">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-emerald-500/10 text-emerald-500 transition group-hover:bg-emerald-500/20">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.8">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m6-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm10 10v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>

                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-neutral-800 dark:text-white">
                                    Usuarios
                                </p>

                                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                                    Administrar usuarios
                                </p>
                            </div>

                            <span class="text-neutral-400 transition group-hover:translate-x-1 group-hover:text-emerald-500">
                                →
                            </span>

                        </a>
                    @endcan


                    {{-- ROLES --}}
                    @can('Listado de Roles')
                        <a href="{{ route('admin.roles.index') }}"
                           class="group flex items-center gap-3 rounded-xl border border-neutral-200 p-3 transition hover:border-amber-500/50 hover:bg-amber-500/5 dark:border-neutral-800">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-amber-500/10 text-amber-500 transition group-hover:bg-amber-500/20">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.8">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 3 4 7v5c0 5 3.5 7.5 8 9 4.5-1.5 8-4 8-9V7l-8-4Z"/>
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="m9 12 2 2 4-4"/>
                                </svg>

                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-neutral-800 dark:text-white">
                                    Roles y permisos
                                </p>

                                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                                    Controlar accesos
                                </p>
                            </div>

                            <span class="text-neutral-400 transition group-hover:translate-x-1 group-hover:text-amber-500">
                                →
                            </span>

                        </a>
                    @endcan


                    {{-- SIN ACCESOS DISPONIBLES --}}
                    @cannot('Listado de Productos')
                        @cannot('Listado de Categorías')
                            @cannot('Listado de Usuarios')
                                @cannot('Listado de Roles')

                                    <div class="rounded-xl border border-dashed border-neutral-300 px-4 py-8 text-center dark:border-neutral-700">

                                        <p class="text-sm text-neutral-500 dark:text-neutral-400">
                                            No tienes accesos rápidos disponibles con tus permisos actuales.
                                        </p>

                                    </div>

                                @endcannot
                            @endcannot
                        @endcannot
                    @endcannot

                </div>

            </div>

        </div>



    </div>

</x-layouts::app>
