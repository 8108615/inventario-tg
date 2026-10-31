<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main class="pb-20">

        {{-- CONTENIDO DEL MÓDULO --}}
        {{ $slot }}

        {{-- FOOTER GLOBAL FIJO --}}
        <footer
            class="fixed bottom-0 left-0 right-0 z-50 border-t border-zinc-200 bg-white px-4 py-3 dark:border-zinc-700 dark:bg-zinc-900 lg:left-64">

            <div
                class="flex flex-col items-center justify-between gap-1 text-center text-xs text-zinc-500 dark:text-zinc-400 sm:flex-row sm:text-left">

                {{-- ESQUINA INFERIOR IZQUIERDA --}}
                <span>
                    © {{ date('Y') }} Sistema de Inventario - THE GAME SRL. Todos los derechos reservados.
                </span>

                {{-- ESQUINA INFERIOR DERECHA --}}
                <span>
                    Desarrollado por:
                    <strong class="text-zinc-700 dark:text-zinc-200">
                        ERICK FERNANDO MORALES GIL
                    </strong>
                </span>

            </div>

        </footer>

        {{-- ALERTA PARA ERRORES DE VALIDACIÓN --}}
        @if ($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: '¡Revisa los campos!',
                    text: 'Algunos datos son incorrectos o faltan por completar.',
                    confirmButtonColor: '#3b82f6'
                });
            </script>
        @endif

        {{-- ALERTAS GLOBALES DE ÉXITO O ERROR --}}
        @if (($mensaje = Session::get('mensaje')) && ($icono = Session::get('icono')))
            <script>
                Swal.fire({
                    position: "top-end",
                    icon: @json($icono),
                    title: @json($mensaje),
                    showConfirmButton: {{ $icono === 'error' ? 'true' : 'false' }},
                    timer: {{ $icono === 'error' ? 'null' : '4000' }}
                });
            </script>
        @endif

    </flux:main>

    @stack('scripts')
</x-layouts::app.sidebar>
