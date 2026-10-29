<x-layouts::app title="Detalle del Producto">
    <div class="relative mb-6 w-full flex justify-between items-center">
        <flux:heading size="xl" level="1">Detalle del Producto: {{ $producto->nombre }}</flux:heading>

        <!-- Botón Volver con flechita en la parte superior -->
        <a href="{{ route('admin.productos.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold text-sm rounded-lg transition shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver al Listado
        </a>
    </div>
    <flux:separator variant="subtle" class="mb-6" />

    <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg p-6 shadow-sm">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Nombre -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Nombre:</label>
                <p class="text-base font-semibold text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-zinc-900 px-3 py-2 rounded-lg border border-gray-200 dark:border-zinc-700">
                    {{ $producto->nombre }}
                </p>
            </div>

            <!-- Marca -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Marca:</label>
                <p class="text-base text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-zinc-900 px-3 py-2 rounded-lg border border-gray-200 dark:border-zinc-700">
                    {{ $producto->marca ?? 'S/M' }}
                </p>
            </div>

            <!-- Modelo -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Modelo:</label>
                <p class="text-base text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-zinc-900 px-3 py-2 rounded-lg border border-gray-200 dark:border-zinc-700">
                    {{ $producto->modelo ?? 'S/M' }}
                </p>
            </div>

            <!-- Serie -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Serie:</label>
                <p class="text-base text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-zinc-900 px-3 py-2 rounded-lg border border-gray-200 dark:border-zinc-700">
                    {{ $producto->serie ?? 'S/N' }}
                </p>
            </div>

            <!-- Cantidad / Stock -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Cantidad / Stock:</label>
                <p class="text-base text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-zinc-900 px-3 py-2 rounded-lg border border-gray-200 dark:border-zinc-700">
                    {{ $producto->stock }}
                </p>
            </div>

            <!-- Estado -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Estado:</label>
                <div class="bg-gray-50 dark:bg-zinc-900 px-3 py-2 rounded-lg border border-gray-200 dark:border-zinc-700 flex items-center h-[42px]">
                    @if($producto->estado === 'Activo' && !$producto->deleted_at)
                        <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-emerald-500 text-white">Activo</span>
                    @else
                        <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-red-500 text-white">Inactivo</span>
                    @endif
                </div>
            </div>

            <!-- Ubicación del Equipo (Categoría) -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Ubicación del Equipo:</label>
                <p class="text-base text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-zinc-900 px-3 py-2 rounded-lg border border-gray-200 dark:border-zinc-700">
                    {{ $producto->categoria->nombre ?? 'N/A' }}
                </p>
            </div>

            <!-- Código de Barra Visualizado -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Código de Barra:</label>
                <div class="bg-gray-50 dark:bg-zinc-900 p-2 rounded-lg border border-gray-200 dark:border-zinc-700 flex flex-col items-center justify-center">
                    @if($producto->codigo)
                        <svg id="barcodeShow"></svg>
                    @else
                        <span class="text-sm text-gray-400 italic py-2">Sin código asignado</span>
                    @endif
                </div>
            </div>

            <!-- Imagen del Producto (Compacta, recuadro angosto y nombre abajo) -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Imagen del Producto:</label>
                <div class="bg-gray-50 dark:bg-zinc-900 p-3 rounded-lg border border-gray-200 dark:border-zinc-700 inline-flex flex-col items-start gap-2">
                    @if($producto->imagen && file_exists(public_path('productos/' . $producto->imagen)))
                        <div class="h-24 w-24 rounded-2xl border-2 border-slate-200 dark:border-zinc-700 overflow-hidden bg-white dark:bg-zinc-800 flex items-center justify-center shadow-inner flex-shrink-0">
                            <img src="{{ asset('productos/' . $producto->imagen) }}" alt="Imagen del producto" class="h-full w-full object-cover">
                        </div>
                        <span class="text-xs text-gray-700 dark:text-gray-300 font-mono truncate max-w-[200px]" title="{{ $producto->imagen }}">
                            {{ $producto->imagen }}
                        </span>
                    @else
                        <div class="h-24 w-24 rounded-2xl border-2 border-slate-200 dark:border-zinc-700 overflow-hidden bg-white dark:bg-zinc-800 flex items-center justify-center shadow-inner flex-shrink-0">
                            <flux:icon name="photo" class="text-slate-300 dark:text-zinc-600 h-10 w-10" />
                        </div>
                        <span class="text-xs text-gray-400 italic">S/F (Sin Fotografía)</span>
                    @endif
                </div>
            </div>

        </div>

    </div>

    @push('scripts')
    <!-- Librería CDN JsBarcode para renderizar el código de barras -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const codigo = "{{ $producto->codigo }}";
            if (codigo.trim() !== "") {
                try {
                    JsBarcode("#barcodeShow", codigo, {
                        format: "CODE128",
                        lineColor: "#000",
                        width: 2,
                        height: 38,
                        displayValue: true,
                        fontSize: 12,
                        font: "monospace",
                        margin: 5
                    });
                } catch(e) {
                    console.log("No se pudo generar el código de barras");
                }
            }
        });
    </script>
    @endpush
</x-layouts::app>
