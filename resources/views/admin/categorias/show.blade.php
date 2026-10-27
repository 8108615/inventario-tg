<x-layouts::app title="Detalle de Categoría">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">Detalles de la categoría</flux:heading>
        <br>
        <flux:separator variant="subtle" />
    </div>

    <div class="max-w-2xl bg-white dark:bg-zinc-800 p-6 rounded-lg border border-gray-200 dark:border-zinc-700 shadow-sm space-y-4">
        <div>
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Nombre:</span>
            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $categoria->nombre }}</p>
        </div>

        <div>
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Descripción:</span>
            <p class="text-gray-700 dark:text-gray-300">{{ $categoria->descripcion ?? 'Sin descripción registrada.' }}</p>
        </div>

        <div>
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Estado:</span>
            <p>
                @if ($categoria->deleted_at)
                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-red-500 text-white">Inactivo (Eliminado)</span>
                @else
                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-emerald-500 text-white">Activo</span>
                @endif
            </p>
        </div>

        <div class="flex justify-end pt-4">
            <a href="{{ route('admin.categorias.index') }}"
                class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Volver al listado
            </a>
        </div>
    </div>
</x-layouts::app>
