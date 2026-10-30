@props([
    'sidebar' => false,
])

<div class="flex items-center gap-3 px-3 py-3">
    <!-- Logo más grande -->
    <div class="flex aspect-square size-10 shrink-0 items-center justify-center rounded-xl overflow-hidden bg-zinc-800 shadow-md">
        <img src="{{ asset('img/LOGO THE GAME.png') }}" alt="The Game SRL" class="w-full h-full object-contain">
    </div>

    <!-- Textos con mayor tamaño y "THE GAME" centrado con respecto al bloque -->
    <div class="flex flex-col text-left leading-tight overflow-hidden">
        <span class="text-sm font-extrabold uppercase tracking-wider text-zinc-100 truncate">SISTEMA INVENTARIO</span>
        <span class="text-[11px] font-bold text-blue-400 tracking-[0.25em] text-center w-full mt-0.5">THE GAME</span>
    </div>
</div>
