<x-layouts::app title="Editar Categoría">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">Editar categoría: {{ $categoria->nombre }}</flux:heading>
        <br>
        <flux:separator variant="subtle" />
    </div>

    <div class="max-w-2xl bg-white dark:bg-zinc-800 p-6 rounded-lg border border-gray-200 dark:border-zinc-700 shadow-sm">
        <form action="{{ route('admin.categorias.update', $categoria->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre de la Categoría <span class="text-red-500">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre', $categoria->nombre) }}" required
                        class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-900 dark:border-zinc-700 dark:text-white focus:ring focus:ring-blue-300 @error('nombre') border-red-500 @enderror">
                    @error('nombre')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                    <textarea name="descripcion" rows="3"
                        class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-900 dark:border-zinc-700 dark:text-white focus:ring focus:ring-blue-300">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                    @error('descripcion')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estado <span class="text-red-500">*</span></label>
                    <select name="estado" required
                        class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-900 dark:border-zinc-700 dark:text-white focus:ring focus:ring-blue-300">
                        <option value="Activo" {{ old('estado', $categoria->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                        <option value="Inactivo" {{ old('estado', $categoria->estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('estado')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-2 pt-4">
                    <a href="{{ route('admin.categorias.index') }}"
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition">
                        <i class="fas fa-arrow-left mr-2"></i> Cancelar
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition">
                        <i class="fas fa-sync-alt mr-2"></i> Actualizar Categoría
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layouts::app>
