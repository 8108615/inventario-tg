<x-layouts::app title="Editar Producto">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">Editar Producto: {{ $producto->nombre }}</flux:heading>
        <br>
        <flux:separator variant="subtle" />
    </div>

    <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg p-6 shadow-sm">
        <form action="{{ route('admin.productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Nombre -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Nombre (*):</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required
                           class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           placeholder="Ej. ESCRITORIO FORMA L">
                    @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Marca -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Marca:</label>
                    <input type="text" name="marca" value="{{ old('marca', $producto->marca) }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           placeholder="Ej. MARELLI">
                    @error('marca') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Modelo -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Modelo:</label>
                    <input type="text" name="modelo" value="{{ old('modelo', $producto->modelo) }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           placeholder="Ej. S/M">
                    @error('modelo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Serie -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Serie:</label>
                    <input type="text" name="serie" value="{{ old('serie', $producto->serie) }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           placeholder="Ej. S/N">
                    @error('serie') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Cantidad (Stock) -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Cantidad / Stock:</label>
                    <input type="number" name="stock" value="{{ old('stock', $producto->stock) }}" min="0" required
                           class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('stock') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Estado -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Estado (*):</label>
                    <select name="estado" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="Activo" {{ old('estado', $producto->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                        <option value="Inactivo" {{ old('estado', $producto->estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('estado') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Ubicación del Equipo (Categoría) -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Ubicación del Equipo (*):</label>
                    <select name="categoria_id" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">Seleccione una ubicación...</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Código de Barra y Visualización Flotante -->
                <div class="relative">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Código de Barra:</label>
                    <input type="text" name="codigo" id="codigoInput" value="{{ old('codigo', $producto->codigo) }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-900 text-gray-900 dark:text-gray-100 font-mono focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           placeholder="Ej. TG-ADM-0001">
                    <span class="text-xs text-gray-400 mt-1 block">Ingrese o escanee el código de barra del producto.</span>
                    @error('codigo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                    <!-- Contenedor flotante absoluto -->
                    <div id="barcodeContainer" class="absolute left-0 right-0 mt-1 flex justify-center hidden z-20">
                        <div class="p-2 bg-white border border-gray-200 rounded-lg shadow-2xl inline-block">
                            <svg id="barcode"></svg>
                        </div>
                    </div>
                </div>

                <!-- Imagen del Producto (Muestra la actual si existe) -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Imagen del Producto:</label>
                    <div class="flex items-center gap-6 mt-2">
                        <div class="h-20 w-20 flex-shrink-0 relative">
                            <div class="h-full w-full rounded-2xl border-2 border-slate-200 dark:border-zinc-700 overflow-hidden bg-slate-50 dark:bg-zinc-900 flex items-center justify-center shadow-inner">
                                <!-- Si ya tiene imagen previa se muestra, caso contrario se oculta -->
                                <img id="image-preview"
                                     src="{{ $producto->imagen && file_exists(public_path('productos/' . $producto->imagen)) ? asset('productos/' . $producto->imagen) : '#' }}"
                                     alt="Preview"
                                     class="{{ $producto->imagen && file_exists(public_path('productos/' . $producto->imagen)) ? '' : 'hidden' }} h-full w-full object-cover">

                                <flux:icon id="placeholder-icon" name="photo" class="{{ $producto->imagen && file_exists(public_path('productos/' . $producto->imagen)) ? 'hidden' : '' }} text-slate-300 dark:text-zinc-600 h-8 w-8" />
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <input type="file" name="imagen" id="foto-input" class="hidden" accept="image/*">
                            <label for="foto-input" class="cursor-pointer flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-zinc-900 border-2 border-slate-200 dark:border-zinc-700 rounded-xl text-slate-700 dark:text-zinc-200 text-sm font-bold hover:border-blue-500 transition-all shadow-sm">
                                <flux:icon name="cloud-arrow-up" variant="micro" />
                                <span>Cambiar Imagen</span>
                            </label>
                            <span id="file-chosen" class="text-xs text-slate-400 italic">
                                {{ $producto->imagen ? $producto->imagen : 'Ningún archivo seleccionado' }}
                            </span>
                        </div>
                    </div>
                    @error('imagen') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-gray-200 dark:border-zinc-700">
                <a href="{{ route('admin.productos.index') }}"
                   class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition shadow-sm">
                    Actualizar Producto
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <!-- Librería CDN JsBarcode -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

    <script>
        // Script para la vista previa de la imagen al seleccionarla
        (function() {
            const actualBtn = document.getElementById('foto-input');
            if (!actualBtn) return;
            const fileChosen = document.getElementById('file-chosen');
            const preview = document.getElementById('image-preview');
            const placeholderIcon = document.getElementById('placeholder-icon');

            actualBtn.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    fileChosen.textContent = file.name;
                    fileChosen.classList.add('text-blue-600', 'font-medium');
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        placeholderIcon.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        })();

        // Script para renderizar el código de barras dinámicamente
        function renderBarcode() {
            const val = document.getElementById('codigoInput').value.trim();
            const container = document.getElementById('barcodeContainer');

            if (val.length > 0) {
                try {
                    JsBarcode("#barcode", val, {
                        format: "CODE128",
                        lineColor: "#000",
                        width: 2,
                        height: 38,
                        displayValue: true,
                        fontSize: 12,
                        font: "monospace",
                        margin: 5
                    });
                    container.classList.remove('hidden');
                } catch(e) {
                    container.classList.add('hidden');
                }
            } else {
                container.classList.add('hidden');
                document.getElementById('barcode').innerHTML = "";
            }
        }

        document.getElementById('codigoInput').addEventListener('input', renderBarcode);
        document.addEventListener('DOMContentLoaded', renderBarcode);
    </script>
    @endpush
</x-layouts::app>
