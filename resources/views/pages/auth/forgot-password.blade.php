
<x-layouts::auth :title="'Recuperación de contraseña'">

    {{-- Fondo personalizado THE GAME --}}
    <div
        class="fixed inset-0 z-0 bg-cover bg-center bg-no-repeat"
        style="
            background-image:
                linear-gradient(
                    rgba(0, 8, 24, 0.15),
                    rgba(0, 8, 24, 0.35)
                ),
                url('{{ asset('img/FONDO CONTRASEÑA.png') }}');
        ">
    </div>

    {{-- Contenedor principal --}}
    <main class="relative z-10 flex min-h-svh w-full items-center justify-center px-4 py-8">

        {{-- Panel de recuperación --}}
        <div
            class="w-full max-w-[460px] rounded-2xl border border-blue-400/80 bg-[#020d20]/95 px-6 py-6 text-center shadow-[0_0_35px_rgba(0,153,255,0.35)] backdrop-blur-md sm:px-9"
        >

            {{-- Logo THE GAME --}}
            <div class="mb-3 flex justify-center">
                <img
                    src="{{ asset('img/LOGO THE GAME.png') }}"
                    alt="Logo THE GAME SRL"
                    class="h-20 w-20 object-contain"
                >
            </div>

            {{-- Icono de seguridad --}}
            <div
                class="mx-auto mb-3 flex h-11 w-11 items-center justify-center rounded-full bg-blue-500/15 text-blue-400"
            >
                <i class="fa-solid fa-shield-halved text-xl"></i>
            </div>

            {{-- Título --}}
            <h1 class="text-xl font-bold tracking-tight text-white sm:text-2xl">
                Recuperación de contraseña
            </h1>

            {{-- Subtítulo --}}
            <div class="mt-2 flex items-center justify-center gap-3">

                <div class="h-px w-6 bg-blue-500/60"></div>

                <p class="text-[10px] font-semibold tracking-[0.10em] text-blue-400 sm:text-[11px]">
                    Sistema de Inventario - THE GAME SRL
                </p>

                <div class="h-px w-6 bg-blue-500/60"></div>

            </div>

            {{-- Información de recuperación --}}
            <div
                class="mt-5 rounded-xl border border-blue-500/40 bg-blue-950/50 p-4 text-left"
            >

                <div class="flex items-start gap-3">

                    {{-- Icono informativo --}}
                    <div class="shrink-0 pt-0.5">
                        <i class="fa-solid fa-circle-info text-lg text-blue-400"></i>
                    </div>

                    {{-- Contenido --}}
                    <div class="min-w-0">

                        <h2 class="text-sm font-semibold text-blue-300">
                            Restablecimiento de acceso
                        </h2>

                        <p class="mt-2 text-sm leading-5 text-zinc-200">
                            Por motivos de seguridad, el restablecimiento
                            de contraseñas es gestionado únicamente por
                            el administrador del sistema.
                        </p>

                        <p class="mt-3 text-sm leading-5 text-white">
                            Comuníquese con el administrador para solicitar
                            el restablecimiento de su contraseña.
                        </p>

                    </div>

                </div>

            </div>

            {{-- Botón volver al login --}}
            <a
                href="{{ route('login') }}"
                class="mt-5 flex w-full items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition duration-200 hover:bg-blue-700 hover:shadow-[0_0_20px_rgba(37,99,235,0.35)]"
            >

                <i class="fa-solid fa-arrow-left"></i>

                Volver al inicio de sesión

            </a>

            {{-- Derechos reservados --}}
            <p class="mt-4 text-center text-[11px] text-zinc-400">
                © {{ date('Y') }} THE GAME SRL.
                Todos los derechos reservados.
            </p>

        </div>

    </main>

</x-layouts::auth>
