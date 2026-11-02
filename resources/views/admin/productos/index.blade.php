<x-layouts::app title="Listado de Productos">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">Listado de productos</flux:heading>
        <br>
        <flux:separator variant="subtle" />
    </div>

    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
        <div class="text-sm text-gray-600 dark:text-gray-300">
            Inventario: <strong>{{ number_format($productos->total(), 0, ',', '.') }}</strong> productos{{ $buscar !== '' ? ' encontrados' : '' }}
        </div>
        @can('Crear Producto')
            <a href="{{ route('admin.productos.create') }}"
               class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition flex items-center gap-2">
                <i class="fas fa-plus mr-2"></i> Crear nuevo
            </a>
        @endcan
    </div>

    <form method="GET"
        action="{{ route('admin.productos.index') }}"
        class="flex flex-wrap items-end justify-end gap-2 mb-5">

        <div class="w-full sm:w-56">
            <label for="buscar-producto"
                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                Buscar:
            </label>

            <input
                id="buscar-producto"
                name="buscar"
                type="search"
                value="{{ $buscar }}"
                placeholder="Buscar producto..."
                class="w-full rounded-lg border border-gray-300
                    dark:border-zinc-600 bg-white dark:bg-zinc-800
                    text-gray-900 dark:text-gray-100
                    px-3 py-2 focus:outline-none
                    focus:ring-2 focus:ring-blue-500">
        </div>

        <button type="submit"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700
                    text-white font-semibold rounded-lg transition">
            <i class="fas fa-search mr-1"></i> Buscar
        </button>

        @if ($buscar !== '')
            <a href="{{ route('admin.productos.index') }}"
            class="px-4 py-2 bg-zinc-500 hover:bg-zinc-600
                    text-white font-semibold rounded-lg transition">
                Limpiar
            </a>
        @endif

    </form>

    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 mt-2 p-4">
        <table class="min-w-full border-collapse">
            <thead class="bg-gray-50 dark:bg-zinc-900 text-center">
                <tr>
                    @foreach (['Nro', 'Imagen', 'Código', 'Nombre', 'Categoría', 'Marca', 'Modelo', 'Serie', 'Stock', 'Estado', 'Acciones'] as $columna)
                        <th class="px-3 py-3 border-x border-b border-gray-200 dark:border-zinc-700 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ $columna }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-zinc-800">
                @forelse ($productos as $producto)
                    <tr class="even:bg-slate-50 odd:bg-white dark:even:bg-zinc-700/20 dark:odd:bg-zinc-800 hover:bg-blue-50 dark:hover:bg-zinc-700/50 transition">
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 text-center text-sm text-gray-900 dark:text-gray-100">{{ $productos->firstItem() + $loop->index }}</td>
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 text-center">
                            @if ($producto->imagen && is_file(public_path('productos/' . $producto->imagen)))
                                <img src="{{ asset('productos/' . $producto->imagen) }}" alt="Imagen de {{ $producto->nombre }}" loading="lazy" width="48" height="48" class="w-12 h-12 object-cover rounded-md shadow mx-auto">
                            @else
                                <span class="text-xs text-gray-400 italic">S/F</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 whitespace-nowrap text-xs font-mono font-semibold text-gray-900 dark:text-gray-100">{{ $producto->codigo ?? 'N/A' }}</td>
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $producto->nombre }}</td>
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 text-center whitespace-nowrap">
                            <span class="bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $producto->categoria?->nombre ?? 'N/A' }}</span>
                        </td>
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 text-sm text-gray-900 dark:text-gray-100">{{ $producto->marca ?? 'S/M' }}</td>
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 text-sm text-gray-900 dark:text-gray-100">{{ $producto->modelo ?? 'S/M' }}</td>
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 text-sm text-gray-900 dark:text-gray-100">{{ $producto->serie ?? 'S/N' }}</td>
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 text-center text-sm text-gray-900 dark:text-gray-100">{{ $producto->stock }}</td>
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 text-center whitespace-nowrap">
                            @if ($producto->deleted_at || $producto->estado === 'Inactivo')
                                <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-red-500 text-white">Inactivo</span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-emerald-500 text-white">Activo</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2">
                                @if ($producto->deleted_at)
                                    @can('Restaurar Producto')
                                        <form method="POST" action="{{ route('admin.productos.restaurar', $producto->id) }}" class="form-confirmar inline" data-accion="restaurar" data-nombre="{{ $producto->nombre }}">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold rounded transition"><i class="fas fa-undo-alt mr-1"></i> Restaurar</button>
                                        </form>
                                    @endcan
                                @else
                                    @can('Ver Producto')
                                        <a href="{{ route('admin.productos.show', $producto->id) }}" class="inline-flex items-center px-3 py-1.5 bg-zinc-500 hover:bg-zinc-600 text-white text-xs font-semibold rounded transition"><i class="fas fa-eye mr-1"></i> Ver</a>
                                    @endcan
                                    @can('Editar Producto')
                                        <a href="{{ route('admin.productos.edit', $producto->id) }}" class="inline-flex items-center px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-semibold rounded transition"><i class="fas fa-pencil-alt mr-1"></i> Editar</a>
                                    @endcan
                                    @can('Eliminar Producto')
                                        <form method="POST" action="{{ route('admin.productos.destroy', $producto->id) }}" class="form-confirmar inline" data-accion="eliminar" data-nombre="{{ $producto->nombre }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded transition"><i class="fas fa-trash-alt mr-1"></i> Eliminar</button>
                                        </form>
                                    @endcan
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="11" class="px-4 py-8 text-center text-gray-500 dark:text-gray-300">No se encontraron productos.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5 flex flex-col gap-3">
        <p class="text-sm text-gray-600 dark:text-gray-300">
            @if ($productos->total() > 0)
                Mostrando {{ $productos->firstItem() }} a {{ $productos->lastItem() }} de {{ number_format($productos->total(), 0, ',', '.') }} productos
            @else
                No hay productos para mostrar.
            @endif
        </p>
        {{ $productos->links('vendor.pagination.tailwind') }}
    </div>

    @push('scripts')
        <script>
            document.addEventListener('submit', function (event) {
                const formulario = event.target.closest('.form-confirmar');
                if (!formulario) return;
                event.preventDefault();
                const restaurar = formulario.dataset.accion === 'restaurar';
                if (typeof Swal === 'undefined') {
                    if (window.confirm(restaurar ? '¿Desea restaurar este producto?' : '¿Desea eliminar este producto?')) {
                        HTMLFormElement.prototype.submit.call(formulario);
                    }
                    return;
                }
                Swal.fire({
                    title: restaurar ? '¿Desea restaurar este producto?' : '¿Desea eliminar este producto?',
                    text: formulario.dataset.nombre,
                    icon: restaurar ? 'question' : 'warning',
                    showCancelButton: true,
                    confirmButtonText: restaurar ? 'Restaurar' : 'Eliminar',
                    confirmButtonColor: restaurar ? '#ca8a04' : '#a5161d',
                    cancelButtonText: 'Cancelar'
                }).then(resultado => {
                    if (resultado.isConfirmed) HTMLFormElement.prototype.submit.call(formulario);
                });
            });
        </script>
    @endpush
</x-layouts::app>
