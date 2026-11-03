
<x-layouts::app title="Listado de Categorías">

    {{-- Encabezado --}}
    <div class="relative mb-4 w-full">
        <flux:heading size="xl" level="1">
            Listado de categorías
        </flux:heading>

        <div class="mt-4">
            <flux:separator variant="subtle" />
        </div>
    </div>

    {{-- Botones superiores --}}
    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">

        <div class="flex flex-wrap items-center gap-2">
            {{-- ============================================ --}}
            {{-- EXPORTAR CSV --}}
            {{-- ============================================ --}}
            <a href="{{ route('admin.categorias.exportar.csv', ['buscar' => $buscar]) }}"
                class="inline-flex items-center gap-2 rounded-lg
                    bg-blue-600 hover:bg-blue-700
                    px-4 py-2 text-sm font-semibold text-white transition">

                <i class="fas fa-file-csv"></i>
                CSV
            </a>

            {{-- ============================================ --}}
            {{-- EXPORTAR EXCEL --}}
            {{-- ============================================ --}}
            <a href="{{ route('admin.categorias.exportar.excel', ['buscar' => $buscar]) }}"
                class="inline-flex items-center gap-2 rounded-lg
                    bg-green-600 hover:bg-green-700
                    px-4 py-2 text-sm font-semibold text-white transition">

                <i class="fas fa-file-excel"></i>
                Excel
            </a>

            {{-- ============================================ --}}
            {{-- EXPORTAR PDF --}}
            {{-- ============================================ --}}
            <a href="{{ route('admin.categorias.exportar.pdf', ['buscar' => $buscar]) }}"
                class="inline-flex items-center gap-2 rounded-lg
                    bg-red-600 hover:bg-red-700
                    px-4 py-2 text-sm font-semibold text-white transition">

                <i class="fas fa-file-pdf"></i>
                PDF
            </a>


            {{-- Copiar categorías --}}
            <button
                type="button"
                id="btnCopiarCategorias"
                data-url="{{ route('admin.categorias.copiar', ['buscar' => $buscar]) }}"
                class="inline-flex items-center gap-2 rounded-lg bg-gray-600 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700 transition"
            >
                <i class="fas fa-copy"></i>
                Copiar
            </button>

        </div>

        @can('Crear Categoría')
            <a href="{{ route('admin.categorias.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-500 px-4 py-2 text-white font-semibold hover:bg-blue-600 transition">
                <i class="fas fa-plus"></i>
                Crear nuevo
            </a>
        @endcan

    </div>

    {{-- Mostrar entradas y buscar --}}
    <form method="GET"
        action="{{ route('admin.categorias.index') }}"
        class="flex flex-wrap items-end justify-between gap-3 mb-3">

        <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-200">
            <label for="por_pagina">Mostrar</label>

            <select id="por_pagina"
                name="por_pagina"
                onchange="this.form.submit()"
                class="rounded-lg border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-gray-100 px-3 py-2">

                @foreach ([10, 25, 50, 100] as $cantidad)
                    <option value="{{ $cantidad }}"
                        {{ $porPagina == $cantidad ? 'selected' : '' }}>
                        {{ $cantidad }}
                    </option>
                @endforeach

            </select>

            <span>entradas</span>
        </div>

        <div class="flex flex-wrap items-end gap-2">

            <div class="w-full sm:w-56">
                <label for="buscar-categoria"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                    Buscar:
                </label>

                <input
                    id="buscar-categoria"
                    name="buscar"
                    type="search"
                    value="{{ $buscar }}"
                    placeholder="Buscar categoría..."
                    class="w-full rounded-lg border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-gray-100 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit"
                class="rounded-lg bg-blue-600 hover:bg-blue-700 px-4 py-2 text-white font-semibold transition">
                <i class="fas fa-search mr-1"></i>
                Buscar
            </button>

            @if ($buscar !== '')
                <a href="{{ route('admin.categorias.index', ['por_pagina' => $porPagina]) }}"
                    class="rounded-lg bg-zinc-500 hover:bg-zinc-600 px-4 py-2 text-white font-semibold transition">
                    Limpiar
                </a>
            @endif

        </div>

    </form>

    {{-- Tabla --}}
    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 p-3">

        <table class="min-w-full border-collapse">

            <thead class="bg-gray-50 dark:bg-zinc-900 text-center">
                <tr>
                    @foreach (['NRO', 'NOMBRE', 'DESCRIPCIÓN', 'ESTADO', 'ACCIONES'] as $titulo)
                        <th class="px-4 py-3 border border-gray-200 dark:border-zinc-700 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">
                            {{ $titulo }}
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody class="bg-white dark:bg-zinc-800">

                @forelse ($categorias as $categoria)

                    <tr class="even:bg-slate-50 odd:bg-white dark:even:bg-zinc-700/20 dark:odd:bg-zinc-800 hover:bg-blue-50 dark:hover:bg-zinc-700/50 transition">

                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 text-sm text-center text-gray-900 dark:text-gray-100">
                            {{ $categorias->firstItem() + $loop->index }}
                        </td>

                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 text-sm font-semibold text-gray-900 dark:text-gray-100">
                            {{ $categoria->nombre }}
                        </td>

                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 text-sm text-gray-900 dark:text-gray-100">
                            {{ $categoria->descripcion ?? 'Sin descripción' }}
                        </td>

                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 text-center text-sm">

                            @if ($categoria->deleted_at || $categoria->estado === 'Inactivo')
                                <span class="inline-flex rounded-full bg-red-500 px-3 py-1 text-xs font-semibold text-white">
                                    Inactivo
                                </span>
                            @else
                                <span class="inline-flex rounded-full bg-emerald-500 px-3 py-1 text-xs font-semibold text-white">
                                    Activo
                                </span>
                            @endif

                        </td>

                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 text-center">

                            @if ($categoria->deleted_at)

                                @can('Restaurar Categoría')
                                    <form method="POST"
                                        action="{{ route('admin.categorias.restaurar', $categoria->id) }}"
                                        class="form-confirmar inline-block"
                                        data-accion="restaurar"
                                        data-nombre="{{ $categoria->nombre }}">
                                        @csrf

                                        <button type="submit"
                                            class="rounded bg-yellow-500 hover:bg-yellow-600 px-3 py-1.5 text-xs font-semibold text-white">
                                            <i class="fas fa-undo-alt mr-1"></i>
                                            Restaurar
                                        </button>
                                    </form>
                                @endcan

                            @else

                                <div class="flex flex-wrap justify-center gap-2">

                                    @can('Ver Categoría')
                                        <a href="{{ route('admin.categorias.show', $categoria->id) }}"
                                            class="rounded bg-zinc-500 hover:bg-zinc-600 px-3 py-1.5 text-xs font-semibold text-white">
                                            <i class="fas fa-eye mr-1"></i> Ver
                                        </a>
                                    @endcan

                                    @can('Editar Categoría')
                                        <a href="{{ route('admin.categorias.edit', $categoria->id) }}"
                                            class="rounded bg-green-500 hover:bg-green-600 px-3 py-1.5 text-xs font-semibold text-white">
                                            <i class="fas fa-pencil-alt mr-1"></i> Editar
                                        </a>
                                    @endcan

                                    @can('Eliminar Categoría')
                                        <form method="POST"
                                            action="{{ route('admin.categorias.destroy', $categoria->id) }}"
                                            class="form-confirmar"
                                            data-accion="eliminar"
                                            data-nombre="{{ $categoria->nombre }}">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="rounded bg-red-500 hover:bg-red-600 px-3 py-1.5 text-xs font-semibold text-white">
                                                <i class="fas fa-trash-alt mr-1"></i>
                                                Eliminar
                                            </button>
                                        </form>
                                    @endcan

                                </div>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5"
                            class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                            No se encontraron categorías.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- Información y paginación --}}
    <div class="flex flex-wrap items-center justify-between gap-4 mt-4">

        <div class="text-sm text-gray-600 dark:text-gray-300">
            @if ($categorias->total() > 0)
                Mostrando {{ $categorias->firstItem() }}
                a {{ $categorias->lastItem() }}
                de {{ number_format($categorias->total(), 0, ',', '.') }}
                categorías
            @else
                Mostrando 0 categorías
            @endif
        </div>

        <div>
            {{ $categorias->links('vendor.pagination.tailwind') }}
        </div>

    </div>


    {{-- Confirmaciones y copiar categorías --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                // ============================================
                // 1. CONFIRMACIONES: ELIMINAR Y RESTAURAR
                // ============================================

                document.querySelectorAll('.form-confirmar').forEach(function (formulario) {

                    formulario.addEventListener('submit', function (evento) {
                        evento.preventDefault();

                        const accion = formulario.dataset.accion;
                        const nombre = formulario.dataset.nombre;

                        const titulo = accion === 'restaurar'
                            ? '¿Desea restaurar esta categoría?'
                            : '¿Desea eliminar esta categoría?';

                        if (typeof Swal === 'undefined') {
                            if (confirm(titulo + '\n' + nombre)) {
                                formulario.submit();
                            }
                            return;
                        }

                        Swal.fire({
                            title: titulo,
                            text: nombre,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: accion === 'restaurar'
                                ? 'Restaurar'
                                : 'Eliminar',
                            cancelButtonText: 'Cancelar',
                            confirmButtonColor: accion === 'restaurar'
                                ? '#d97706'
                                : '#dc2626'
                        }).then(function (resultado) {
                            if (resultado.isConfirmed) {
                                formulario.submit();
                            }
                        });
                    });

                });


                // ============================================
                // 2. COPIAR CATEGORÍAS AL PORTAPAPELES
                // ============================================

                const boton = document.getElementById('btnCopiarCategorias');

                if (boton) {

                    boton.addEventListener('click', async function () {

                        try {

                            const respuesta = await fetch(boton.dataset.url, {
                                credentials: 'same-origin',
                                headers: {
                                    'Accept': 'text/plain'
                                }
                            });

                            if (!respuesta.ok) {
                                throw new Error('Error HTTP: ' + respuesta.status);
                            }

                            const texto = await respuesta.text();

                            // Método moderno: HTTPS o contexto seguro
                            if (navigator.clipboard && window.isSecureContext) {

                                await navigator.clipboard.writeText(texto);

                            } else {

                                // Método alternativo para HTTP local
                                const textarea = document.createElement('textarea');

                                textarea.value = texto;
                                textarea.setAttribute('readonly', '');

                                textarea.style.position = 'fixed';
                                textarea.style.left = '-9999px';
                                textarea.style.top = '0';

                                document.body.appendChild(textarea);

                                textarea.focus();
                                textarea.select();

                                const copiado = document.execCommand('copy');

                                document.body.removeChild(textarea);

                                if (!copiado) {
                                    throw new Error('El navegador no permitió copiar.');
                                }
                            }

                            // Mensaje de éxito
                            if (typeof Swal !== 'undefined') {

                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Categorías copiadas!',
                                    text: 'Las categorías están listas para pegar en Excel.',
                                    confirmButtonText: 'Aceptar',
                                    confirmButtonColor: '#2563eb'
                                });

                            } else {
                                alert('¡Categorías copiadas correctamente!');
                            }

                        } catch (error) {

                            console.error('Error al copiar categorías:', error);

                            if (typeof Swal !== 'undefined') {

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error al copiar',
                                    text: 'No se pudieron copiar las categorías.',
                                    confirmButtonText: 'Aceptar'
                                });

                            } else {
                                alert('No se pudieron copiar las categorías.');
                            }

                        }

                    });

                }

            });
        </script>
    @endpush


    {{-- ============================================
        3. MENSAJES DE ÉXITO
        ============================================ --}}

    @if (session('success'))
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {

                    if (typeof Swal !== 'undefined') {

                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: @json(session('success')),
                            confirmButtonColor: '#3b82f6',
                            timer: 3000,
                            timerProgressBar: true
                        });

                    }

                });
            </script>
        @endpush
    @endif

</x-layouts::app>

