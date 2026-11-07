<x-layouts::app :title="__('Dashboard')">
    <div class="mx-auto max-w-[1700px] space-y-7 p-4 md:p-7">
        {{-- Encabezado --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-[0.2em] text-blue-500">
                    <span class="h-2 w-2 rounded-full bg-blue-500"></span> THE GAME SRL
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white md:text-3xl">Panel de control</h1>
                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Bienvenido, {{ auth()->user()->name }}. Aquí tienes el resumen de tu inventario.</p>
            </div>
            <div class="inline-flex items-center gap-3 self-start rounded-2xl border border-zinc-200 bg-white px-4 py-3 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-500/10 text-blue-500">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M7 3v4m10-4v4M3 10h18"/></svg>
                </div>
                <div><p class="text-xs text-zinc-500 dark:text-zinc-400">Fecha actual</p><p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ now()->locale('es')->translatedFormat('d M, Y') }}</p></div>
            </div>
        </div>

        {{-- Indicadores: únicamente módulos autorizados --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-5">
            @if ($puedeVerProductos)
            <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex items-start justify-between gap-2"><p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total de productos</p><span class="rounded-xl bg-blue-500/10 p-2.5 text-blue-500"><svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="m3 7 9-4 9 4v10l-9 4-9-4V7Zm0 0 9 4 9-4m-9 4v10"/></svg></span></div>
                <p class="mt-3 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ number_format($totalProductos, 0, ',', '.') }}</p><p class="mt-3 text-xs text-zinc-500 dark:text-zinc-400"><span class="mr-1 text-blue-500">●</span> Inventario registrado</p>
            </div>
            <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex items-start justify-between gap-2"><p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Productos activos</p><span class="rounded-xl bg-emerald-500/10 p-2.5 text-emerald-500"><svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="m8 12 3 3 5-6"/></svg></span></div>
                <p class="mt-3 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ number_format($productosActivos, 0, ',', '.') }}</p><p class="mt-3 text-xs text-emerald-500"><span class="mr-1">●</span> Disponibles en el sistema</p>
            </div>
            <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex items-start justify-between gap-2"><p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Productos inactivos</p><span class="rounded-xl bg-amber-500/10 p-2.5 text-amber-500"><svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v6m0 4h.01"/></svg></span></div>
                <p class="mt-3 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ number_format($productosInactivos, 0, ',', '.') }}</p><p class="mt-3 text-xs text-amber-500"><span class="mr-1">●</span> Productos dados de baja</p>
            </div>
            @endif
            @if ($puedeVerCategorias)
            <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex items-start justify-between gap-2"><p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Categorías</p><span class="rounded-xl bg-violet-500/10 p-2.5 text-violet-500"><svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg></span></div>
                <p class="mt-3 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ number_format($totalCategorias, 0, ',', '.') }}</p><p class="mt-3 text-xs text-violet-500"><span class="mr-1">●</span> {{ number_format($categoriasActivas, 0, ',', '.') }} categorías activas</p>
            </div>
            @endif
            @if ($puedeVerUsuarios)
            <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex items-start justify-between gap-2"><p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Usuarios registrados</p><span class="rounded-xl bg-indigo-500/10 p-2.5 text-indigo-500"><svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="9" cy="8" r="4"/><path d="M2 21v-2a7 7 0 0 1 14 0v2m1-16a4 4 0 0 1 0 7m1 3a6 6 0 0 1 4 6"/></svg></span></div>
                <p class="mt-3 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ number_format($totalUsuarios, 0, ',', '.') }}</p><p class="mt-3 text-xs text-zinc-500 dark:text-zinc-400"><span class="text-emerald-500">● {{ $usuariosActivos }} activos</span> <span class="ml-2">● {{ $usuariosInactivos }} inactivos</span></p>
            </div>
            @endif
        </div>

        {{-- Distribución y accesos rápidos --}}
        <div class="grid grid-cols-1 gap-5 {{ $puedeVerProductos && $puedeVerCategorias ? 'xl:grid-cols-3' : 'xl:grid-cols-1' }}">
            @if ($puedeVerProductos && $puedeVerCategorias)
            <section class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 md:p-6 xl:col-span-2">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div><h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Productos por categoría</h2><p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Las seis categorías activas con más productos.</p></div>
                    @can('Listado de Categorías')<a href="{{ route('admin.categorias.index') }}" class="text-sm font-semibold text-blue-500 hover:text-blue-400">Ver categorías &rarr;</a>@endcan
                </div>
                <div class="mt-7 space-y-6">
                    @forelse ($productosPorCategoria as $categoria)
                        @php
                            $cantidad = (int) $categoria->productos_count;
                            $ancho = $maxProductosCategoria > 0 ? min(100, max(0, ($cantidad / $maxProductosCategoria) * 100)) : 0;
                            $participacion = $totalProductos > 0 ? ($cantidad / $totalProductos) * 100 : 0;
                        @endphp
                        <div>
                            <div class="mb-2 flex flex-wrap items-center justify-between gap-2"><span class="min-w-0 truncate text-sm font-medium text-zinc-700 dark:text-zinc-200" title="{{ $categoria->nombre }}">{{ $categoria->nombre }}</span><span class="shrink-0 text-sm font-semibold text-zinc-900 dark:text-white">{{ number_format($cantidad, 0, ',', '.') }} <span class="ml-1 font-normal text-zinc-500 dark:text-zinc-400">({{ number_format($participacion, 1, ',', '.') }}%)</span></span></div>
                            <div class="h-2.5 overflow-hidden rounded-full bg-zinc-100 dark:bg-zinc-800"><div class="h-full rounded-full bg-blue-500 transition-all duration-500" style="width: {{ $ancho }}%"></div></div>
                        </div>
                    @empty
                        <div class="rounded-xl border border-dashed border-zinc-300 p-8 text-center text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">No hay categorías activas para mostrar.</div>
                    @endforelse
                </div>
                <p class="mt-7 border-t border-zinc-100 pt-4 text-xs text-zinc-500 dark:border-zinc-800 dark:text-zinc-400">El porcentaje indica la proporción respecto al total de productos registrados. Las barras se escalan respecto a la categoría con mayor cantidad.</p>
            </section>
            @endif

            <section class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 md:p-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Accesos rápidos</h2><p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Gestiona los módulos autorizados.</p>
                <div class="mt-6 space-y-3">
                    @can('Listado de Productos')
                        <a href="{{ route('admin.productos.index') }}" class="group flex items-center gap-3 rounded-xl border border-zinc-200 p-3 transition hover:border-blue-500/50 hover:bg-blue-500/5 dark:border-zinc-800"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-500/10 text-blue-500"><svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="m3 7 9-4 9 4v10l-9 4-9-4V7Zm0 0 9 4 9-4m-9 4v10"/></svg></span><span class="min-w-0 flex-1"><span class="block text-sm font-semibold text-zinc-900 dark:text-white">Productos</span><span class="block text-xs text-zinc-500 dark:text-zinc-400">Gestionar inventario</span></span><span class="text-zinc-400 transition group-hover:translate-x-1 group-hover:text-blue-500">&rarr;</span></a>
                    @endcan
                    @can('Listado de Categorías')
                        <a href="{{ route('admin.categorias.index') }}" class="group flex items-center gap-3 rounded-xl border border-zinc-200 p-3 transition hover:border-violet-500/50 hover:bg-violet-500/5 dark:border-zinc-800"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-violet-500/10 text-violet-500"><svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg></span><span class="min-w-0 flex-1"><span class="block text-sm font-semibold text-zinc-900 dark:text-white">Categorías</span><span class="block text-xs text-zinc-500 dark:text-zinc-400">Organizar productos</span></span><span class="text-zinc-400 transition group-hover:translate-x-1 group-hover:text-violet-500">&rarr;</span></a>
                    @endcan
                    @can('Listado de Usuarios')
                        <a href="{{ route('admin.usuarios.index') }}" class="group flex items-center gap-3 rounded-xl border border-zinc-200 p-3 transition hover:border-emerald-500/50 hover:bg-emerald-500/5 dark:border-zinc-800"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-500/10 text-emerald-500"><svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="9" cy="8" r="4"/><path d="M2 21v-2a7 7 0 0 1 14 0v2"/></svg></span><span class="min-w-0 flex-1"><span class="block text-sm font-semibold text-zinc-900 dark:text-white">Usuarios</span><span class="block text-xs text-zinc-500 dark:text-zinc-400">Administrar usuarios</span></span><span class="text-zinc-400 transition group-hover:translate-x-1 group-hover:text-emerald-500">&rarr;</span></a>
                    @endcan
                    @can('Listado de Roles')
                        <a href="{{ route('admin.roles.index') }}" class="group flex items-center gap-3 rounded-xl border border-zinc-200 p-3 transition hover:border-amber-500/50 hover:bg-amber-500/5 dark:border-zinc-800"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-amber-500/10 text-amber-500"><svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="m12 3 8 4v5c0 5-3.5 7.5-8 9-4.5-1.5-8-4-8-9V7l8-4Z"/><path d="m9 12 2 2 4-4"/></svg></span><span class="min-w-0 flex-1"><span class="block text-sm font-semibold text-zinc-900 dark:text-white">Roles y permisos</span><span class="block text-xs text-zinc-500 dark:text-zinc-400">Controlar accesos</span></span><span class="text-zinc-400 transition group-hover:translate-x-1 group-hover:text-amber-500">&rarr;</span></a>
                    @endcan
                    @cannot('Listado de Productos')
                        @cannot('Listado de Categorías')
                            @cannot('Listado de Usuarios')
                                @cannot('Listado de Roles')
                                    <p class="rounded-xl border border-dashed border-zinc-300 p-6 text-center text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">No tienes accesos rápidos disponibles con tus permisos actuales.</p>
                                @endcannot
                            @endcannot
                        @endcannot
                    @endcannot
                </div>
            </section>
        </div>
    </div>
</x-layouts::app>
