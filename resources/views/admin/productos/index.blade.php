<x-layouts::app title="Listado de Productos">
    <!-- Cargar estilos y scripts necesarios para DataTables y botones de exportación -->
    @push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.tailwindcss.min.css">
    @endpush

    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">Listado de productos</flux:heading>
        <br>
        <flux:separator variant="subtle" />
    </div>

    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
        <!-- Botones de Exportación (Copy, Excel, CSV, PDF) -->
        <div id="export-buttons-container" class="flex flex-wrap gap-2"></div>

        <!-- Botón Crear Nuevo -->
        <div>
            <a href="{{ route('admin.productos.create') }}"
                class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition flex items-center gap-2">
                <i class="fas fa-plus mr-2"></i>
                Crear nuevo
            </a>
        </div>
    </div>

    <!-- Tabla con IDs y clases para DataTables -->
    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 mt-2 p-4">
        <table id="tablaProductos" class="min-w-full border-collapse text-sm text-gray-700 dark:text-gray-300">
            <thead class="bg-gray-50 dark:bg-zinc-900 text-center">
                <tr>
                    <th class="px-3 py-3 border-x border-b border-gray-200 dark:border-zinc-700 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nro</th>
                    <th class="px-3 py-3 border-x border-b border-gray-200 dark:border-zinc-700 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Imagen</th>
                    <th class="px-3 py-3 border-x border-b border-gray-200 dark:border-zinc-700 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Código</th>
                    <th class="px-3 py-3 border-x border-b border-gray-200 dark:border-zinc-700 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                    <th class="px-3 py-3 border-x border-b border-gray-200 dark:border-zinc-700 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Categoría</th>
                    <th class="px-3 py-3 border-x border-b border-gray-200 dark:border-zinc-700 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Marca / Modelo</th>
                    <th class="px-3 py-3 border-x border-b border-gray-200 dark:border-zinc-700 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Stock</th>
                    <th class="px-3 py-3 border-x border-b border-gray-200 dark:border-zinc-700 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                    <th class="px-3 py-3 border-x border-b border-gray-200 dark:border-zinc-700 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-zinc-800">
                @foreach ($productos as $index => $producto)
                    <tr class="even:bg-slate-50 odd:bg-white dark:even:bg-zinc-700/20 dark:odd:bg-zinc-800 hover:bg-blue-50 dark:hover:bg-zinc-700/50 transition">
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 text-center font-medium">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 whitespace-nowrap text-center">
                            @if($producto->imagen && file_exists(public_path('productos/' . $producto->imagen)))
                                <img src="{{ asset('productos/' . $producto->imagen) }}" alt="Foto" class="w-10 h-10 object-cover rounded-md shadow mx-auto">
                            @else
                                <span class="text-xs text-gray-400 italic">S/F</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 whitespace-nowrap text-sm font-mono font-semibold text-gray-900 dark:text-gray-100">
                            {{ $producto->codigo }}
                        </td>
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 text-sm font-bold text-gray-900 dark:text-gray-100">
                            {{ $producto->nombre }}
                        </td>
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 whitespace-nowrap text-sm">
                            <span class="bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 text-xs font-semibold px-2.5 py-0.5 rounded">
                                {{ $producto->categoria->nombre ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 text-xs text-gray-900 dark:text-gray-100">
                            <div><strong>Marca:</strong> {{ $producto->marca ?? 'S/M' }}</div>
                            <div class="text-gray-500 dark:text-gray-400"><strong>Modelo:</strong> {{ $producto->modelo ?? 'S/M' }}</div>
                        </td>
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 whitespace-nowrap text-sm text-center font-bold text-gray-900 dark:text-gray-100">
                            {{ $producto->stock }}
                        </td>
                        <td class="text-center px-3 py-2 border border-gray-200 dark:border-zinc-700 whitespace-nowrap text-sm">
                            @if ($producto->deleted_at)
                                <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-red-500 text-white">Inactivo</span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-emerald-500 text-white">Activo</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 whitespace-nowrap text-center">
                            <div class="flex justify-center gap-1">
                                <a href="{{ route('admin.productos.show', ['id' => $producto->id]) }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-zinc-500 hover:bg-zinc-600 text-white text-xs font-semibold rounded transition shadow-sm">
                                    Ver
                                </a>
                                <a href="{{ route('admin.productos.edit', ['id' => $producto->id]) }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-semibold rounded transition">
                                    Editar
                                </a>
                                <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST" id="formEliminarProducto{{ $producto->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded transition cursor-pointer"
                                        onclick="confirmarEliminacionProducto{{ $producto->id }}(event)">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                            <script>
                                function confirmarEliminacionProducto{{ $producto->id }}(event) {
                                    event.preventDefault();
                                    Swal.fire({
                                        title: '¿Desea eliminar este producto?',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Eliminar',
                                        confirmButtonColor: '#a5161d',
                                        cancelButtonText: 'Cancelar',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            document.getElementById('formEliminarProducto{{ $producto->id }}').submit();
                                        }
                                    });
                                }
                            </script>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Scripts necesarios para inicializar DataTables y botones en español -->
    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.tailwindcss.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#tablaProductos').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información disponible en la tabla",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 entradas",
                    "infoFiltered": "(filtrado de _MAX_ entradas totales)",
                    "lengthMenu": "Mostrar _MENU_ entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encontraron registros coincidentes",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                dom: '<"flex flex-col md:flex-row justify-between items-center mb-4"<"mb-2 md:mb-0"l><"flex items-center gap-2"f>>rt<"flex flex-col md:flex-row justify-between items-center mt-4"ip>',
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="fas fa-copy mr-1"></i> Copiar',
                        className: 'px-3 py-1.5 bg-gray-600 hover:bg-gray-700 text-white text-xs font-semibold rounded shadow',
                        exportOptions: { columns: [0, 2, 3, 4, 5, 6, 7] }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel mr-1"></i> Excel',
                        className: 'px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded shadow',
                        exportOptions: { columns: [0, 2, 3, 4, 5, 6, 7] }
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv mr-1"></i> CSV',
                        className: 'px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded shadow',
                        exportOptions: { columns: [0, 2, 3, 4, 5, 6, 7] }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                        className: 'px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded shadow',
                        exportOptions: { columns: [0, 2, 3, 4, 5, 6, 7] }
                    }
                ]
            });

            // Mover los botones al contenedor personalizado arriba de la tabla
            table.buttons().container().appendTo('#export-buttons-container');
        });
    </script>
    @endpush

    @if (session('mensaje'))
        <script>
            Swal.fire({
                icon: "{{ session('icono', 'success') }}",
                title: '¡Éxito!',
                text: "{{ session('mensaje') }}",
                confirmButtonColor: '#3b82f6',
                timer: 3000,
                timerProgressBar: true
            });
        </script>
    @endif
</x-layouts::app>
