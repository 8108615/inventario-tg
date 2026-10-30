<x-layouts::app title="Listado de Productos">
    <!-- Cargar estilos necesarios para DataTables y botones de exportación -->
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
        @can('Crear Producto')
            <div>
                <a href="{{ route('admin.productos.create') }}"
                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-plus mr-2"></i>
                    Crear nuevo
                </a>
            </div>
        @endcan
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
                    <th class="px-3 py-3 border-x border-b border-gray-200 dark:border-zinc-700 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Marca</th>
                    <th class="px-3 py-3 border-x border-b border-gray-200 dark:border-zinc-700 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Modelo</th>
                    <th class="px-3 py-3 border-x border-b border-gray-200 dark:border-zinc-700 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Serie</th>
                    <th class="px-3 py-3 border-x border-b border-gray-200 dark:border-zinc-700 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Stock</th>
                    <th class="px-3 py-3 border-x border-b border-gray-200 dark:border-zinc-700 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                    <th class="px-3 py-3 border-x border-b border-gray-200 dark:border-zinc-700 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-zinc-800">
                <!-- Los datos se cargan dinámicamente vía AJAX desde el servidor de forma instantánea -->
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
        // Usamos un evento compatible con la navegación para asegurar que la tabla cargue siempre
        $(function() {
            // Si la tabla ya estaba inicializada por AJAX previo, la destruimos de forma segura para evitar conflictos
            if ($.fn.DataTable.isDataTable('#tablaProductos')) {
                $('#tablaProductos').DataTable().destroy();
            }

            var table = $('#tablaProductos').DataTable({
                processing: false,
                serverSide: true,
                stateSave: true, // Guarda el estado de la tabla para transiciones fluidas
                ajax: "{{ route('admin.productos.data') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center px-3 py-2 border border-gray-200 dark:border-zinc-700 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 font-medium' },
                    { data: 'imagen_html', name: 'imagen', orderable: false, searchable: false, className: 'text-center px-3 py-2 border border-gray-200 dark:border-zinc-700 whitespace-nowrap' },
                    { data: 'codigo_barra_col', name: 'codigo', className: 'px-3 py-2 border border-gray-200 dark:border-zinc-700 whitespace-nowrap text-sm font-mono font-semibold text-gray-900 dark:text-gray-100' },
                    { data: 'nombre', name: 'nombre', className: 'px-3 py-2 border border-gray-200 dark:border-zinc-700 text-sm font-bold text-gray-900 dark:text-gray-100' },
                    { data: 'categoria_nombre', name: 'categoria.nombre', className: 'px-3 py-2 border border-gray-200 dark:border-zinc-700 whitespace-nowrap text-sm' },
                    { data: 'marca_col', name: 'marca', className: 'px-3 py-2 border border-gray-200 dark:border-zinc-700 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap' },
                    { data: 'modelo_col', name: 'modelo', className: 'px-3 py-2 border border-gray-200 dark:border-zinc-700 text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap' },
                    { data: 'serie_col', name: 'serie', className: 'px-3 py-2 border border-gray-200 dark:border-zinc-700 text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap' },
                    { data: 'stock', name: 'stock', className: 'text-center px-3 py-2 border border-gray-200 dark:border-zinc-700 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-gray-100' },
                    { data: 'estado_html', name: 'estado', className: 'text-center px-3 py-2 border border-gray-200 dark:border-zinc-700 whitespace-nowrap text-sm' },
                    { data: 'acciones', name: 'acciones', orderable: false, searchable: false, className: 'text-center px-3 py-2 border border-gray-200 dark:border-zinc-700 whitespace-nowrap' }
                ],
                createdRow: function(row, data, dataIndex) {
                    $(row).addClass('even:bg-slate-50 odd:bg-white dark:even:bg-zinc-700/20 dark:odd:bg-zinc-800 hover:bg-blue-50 dark:hover:bg-zinc-700/50 transition');
                },
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
                    "processing": "",
                    "search": "Buscar:",
                    "zeroRecords": "No se encontraron registros coincidentes",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                dom: 'B<"flex flex-col md:flex-row justify-between items-center mb-4 mt-4"<"mb-2 md:mb-0"l><"flex items-center gap-2"f>>rt<"flex flex-col md:flex-row justify-between items-center mt-4"ip>',
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="fas fa-copy mr-1"></i> Copiar',
                        className: 'px-3 py-1.5 bg-gray-600 hover:bg-gray-700 text-white text-xs font-semibold rounded shadow',
                        exportOptions: { columns: [0, 2, 3, 4, 5, 6, 7, 8, 9] }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel mr-1"></i> Excel',
                        className: 'px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded shadow',
                        exportOptions: { columns: [0, 2, 3, 4, 5, 6, 7, 8, 9] }
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv mr-1"></i> CSV',
                        className: 'px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded shadow',
                        exportOptions: { columns: [0, 2, 3, 4, 5, 6, 7, 8, 9] }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                        className: 'px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded shadow',
                        exportOptions: { columns: [0, 2, 3, 4, 5, 6, 7, 8, 9] }
                    }
                ]
            });

            // Mover los botones al contenedor superior
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
