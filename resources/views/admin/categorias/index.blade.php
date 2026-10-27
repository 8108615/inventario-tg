<x-layouts::app title="Listado de Categorías">
    <!-- Cargar estilos y scripts necesarios para DataTables y botones de exportación -->
    @push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.tailwindcss.min.css">
    @endpush

    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">Listado de categorías</flux:heading>
        <br>
        <flux:separator variant="subtle" />
    </div>

    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
        <!-- Botones de Exportación (Copy, Excel, CSV, PDF) -->
        <div id="export-buttons-container" class="flex flex-wrap gap-2"></div>

        <!-- Botón Crear Nuevo -->
        <div>
            <a href="{{ route('admin.categorias.create') }}"
                class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition flex items-center gap-2">
                <i class="fas fa-plus mr-2"></i>
                Crear nuevo
            </a>
        </div>
    </div>

    <!-- Tabla con IDs y clases para DataTables -->
    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 mt-2 p-4">
        <table id="tablaCategorias" class="min-w-full border-collapse">
            <thead class="bg-gray-50 dark:bg-zinc-900 text-center">
                <tr>
                    <th class="px-6 py-3 border-x border-b border-gray-200 dark:border-zinc-700 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nro</th>
                    <th class="px-6 py-3 border-x border-b border-gray-200 dark:border-zinc-700 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 border-x border-b border-gray-200 dark:border-zinc-700 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Descripción</th>
                    <th class="px-6 py-3 border-x border-b border-gray-200 dark:border-zinc-700 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 border-x border-b border-gray-200 dark:border-zinc-700 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-zinc-800">
                @foreach ($categorias as $categoria)
                    <tr class="even:bg-slate-50 odd:bg-white dark:even:bg-zinc-700/20 dark:odd:bg-zinc-800 hover:bg-blue-50 dark:hover:bg-zinc-700/50 transition">
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 text-center">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-gray-100">
                            {{ $categoria->nombre }}
                        </td>
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 text-sm text-gray-900 dark:text-gray-100">
                            {{ $categoria->descripcion ?? 'Sin descripción' }}
                        </td>
                        <td class="text-center px-3 py-2 border border-gray-200 dark:border-zinc-700 whitespace-nowrap text-sm">
                            @if ($categoria->deleted_at)
                                <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-red-500 text-white border border-red-200">
                                    Inactivo
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-emerald-500 text-white border border-emerald-200">
                                    Activo
                                </span>
                            @endif
                        </td>
                        <td class="px-3 py-2 border border-gray-200 dark:border-zinc-700 whitespace-nowrap text-center">
                            @if ($categoria->deleted_at)
                                <form action="{{ route('admin.categorias.restaurar', $categoria->id) }}" method="post" id="miFormularioRestaurar{{ $categoria->id }}">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold rounded transition"
                                        onclick="preguntarRestaurar{{ $categoria->id }}(event)">
                                        <i class="fas fa-undo-alt mr-1"></i> Restaurar
                                    </button>
                                </form>
                                <script>
                                    function preguntarRestaurar{{ $categoria->id }}(event) {
                                        event.preventDefault();
                                        Swal.fire({
                                            title: '¿Desea restaurar esta categoría?',
                                            icon: 'question',
                                            showDenyButton: true,
                                            confirmButtonText: 'Restaurar',
                                            confirmButtonColor: '#a68d1e',
                                            denyButtonText: 'Cancelar',
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                document.getElementById('miFormularioRestaurar{{ $categoria->id }}').submit();
                                            }
                                        });
                                    }
                                </script>
                            @else
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.categorias.show', $categoria->id) }}"
                                        class="inline-flex items-center px-3 py-1.5 bg-zinc-500 hover:bg-zinc-600 text-white text-xs font-semibold rounded transition shadow-sm">
                                        <i class="fas fa-eye mr-1"></i> Ver
                                    </a>

                                    <a href="{{ route('admin.categorias.edit', $categoria->id) }}"
                                        class="inline-flex items-center px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-semibold rounded transition">
                                        <i class="fas fa-pencil-alt mr-1"></i> Editar
                                    </a>

                                    <form action="{{ route('admin.categorias.destroy', $categoria->id) }}" method="post" id="miFormularioEliminar{{ $categoria->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded transition cursor-pointer"
                                            onclick="preguntarEliminar{{ $categoria->id }}(event)">
                                            <i class="fas fa-trash-alt mr-1"></i> Eliminar
                                        </button>
                                    </form>

                                    <script>
                                        function preguntarEliminar{{ $categoria->id }}(event) {
                                            event.preventDefault();
                                            Swal.fire({
                                                title: '¿Desea eliminar esta categoría?',
                                                icon: 'question',
                                                showDenyButton: true,
                                                confirmButtonText: 'Eliminar',
                                                confirmButtonColor: '#a5161d',
                                                denyButtonText: 'Cancelar',
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    document.getElementById('miFormularioEliminar{{ $categoria->id }}').submit();
                                                }
                                            });
                                        }
                                    </script>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Scripts necesarios para inicializar DataTables y los botones en español -->
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
            var table = $('#tablaCategorias').DataTable({
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
                        exportOptions: { columns: [0, 1, 2, 3] } // Exporta solo Nro, Nombre, Descripción y Estado
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel mr-1"></i> Excel',
                        className: 'px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded shadow',
                        exportOptions: { columns: [0, 1, 2, 3] }
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv mr-1"></i> CSV',
                        className: 'px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded shadow',
                        exportOptions: { columns: [0, 1, 2, 3] }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                        className: 'px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded shadow',
                        exportOptions: { columns: [0, 1, 2, 3] }
                    }
                ]
            });

            // Mover los botones al contenedor personalizado arriba de la tabla
            table.buttons().container().appendTo('#export-buttons-container');
        });
    </script>
    @endpush

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3b82f6',
                timer: 3000,
                timerProgressBar: true
            });
        </script>
    @endif
</x-layouts::app>
