@if ($paginator->hasPages())
    <nav role="navigation"
         aria-label="Navegación de páginas"
         class="w-full">

        {{-- Paginación para celulares --}}
        <div class="flex items-center justify-between gap-2 sm:hidden">

            @if ($paginator->onFirstPage())
                <span class="px-3 py-2 text-sm text-gray-500
                             bg-zinc-800 border border-zinc-700
                             rounded-lg cursor-not-allowed">
                    Anterior
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   rel="prev"
                   class="px-3 py-2 text-sm text-gray-200
                          bg-zinc-800 border border-zinc-700
                          rounded-lg hover:bg-zinc-700">
                    Anterior
                </a>
            @endif

            <span class="text-sm text-gray-300">
                Página {{ $paginator->currentPage() }}
            </span>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   rel="next"
                   class="px-3 py-2 text-sm text-gray-200
                          bg-zinc-800 border border-zinc-700
                          rounded-lg hover:bg-zinc-700">
                    Siguiente
                </a>
            @else
                <span class="px-3 py-2 text-sm text-gray-500
                             bg-zinc-800 border border-zinc-700
                             rounded-lg cursor-not-allowed">
                    Siguiente
                </span>
            @endif

        </div>

        {{-- Paginación numérica para computadoras --}}
        <div class="hidden sm:flex items-center justify-end">

            <div class="inline-flex flex-wrap items-center
                        justify-end gap-1">

                {{-- Página anterior --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true"
                          class="px-3 py-2 text-sm text-gray-500
                                 bg-zinc-800 border border-zinc-700
                                 rounded-md cursor-not-allowed">
                        &laquo;
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}"
                       rel="prev"
                       aria-label="Página anterior"
                       class="px-3 py-2 text-sm text-gray-200
                              bg-zinc-800 border border-zinc-700
                              rounded-md hover:bg-zinc-700
                              transition">
                        &laquo;
                    </a>
                @endif

                {{-- Números de página --}}
                @foreach ($elements as $element)

                    {{-- Separador --}}
                    @if (is_string($element))
                        <span class="px-3 py-2 text-sm text-gray-400">
                            {{ $element }}
                        </span>
                    @endif

                    {{-- Enlaces numéricos --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)

                            @if ($page == $paginator->currentPage())
                                <span aria-current="page"
                                      class="px-3 py-2 text-sm font-semibold
                                             text-white bg-blue-600
                                             border border-blue-500
                                             rounded-md">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                   aria-label="Ir a la página {{ $page }}"
                                   class="px-3 py-2 text-sm text-gray-200
                                          bg-zinc-800 border border-zinc-700
                                          rounded-md hover:bg-zinc-700
                                          transition">
                                    {{ $page }}
                                </a>
                            @endif

                        @endforeach
                    @endif

                @endforeach

                {{-- Página siguiente --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}"
                       rel="next"
                       aria-label="Página siguiente"
                       class="px-3 py-2 text-sm text-gray-200
                              bg-zinc-800 border border-zinc-700
                              rounded-md hover:bg-zinc-700
                              transition">
                        &raquo;
                    </a>
                @else
                    <span aria-disabled="true"
                          class="px-3 py-2 text-sm text-gray-500
                                 bg-zinc-800 border border-zinc-700
                                 rounded-md cursor-not-allowed">
                        &raquo;
                    </span>
                @endif

            </div>
        </div>

    </nav>
@endif
