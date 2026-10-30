<x-layouts::auth.card :title="__('Iniciar sesión')">
    <div class="login-content">

        {{-- Encabezado con el logo de THE GAME --}}
        <div class="login-brand">
            <img
                src="{{ asset('img/LOGO THE GAME.png') }}"
                alt="THE GAME SRL"
                class="login-logo"
            >

            <div class="login-brand-text">
                <h1>SISTEMA DE INVENTARIO</h1>
                <span>THE GAME SRL</span>
            </div>
        </div>

        <p class="login-description">
            Controla, organiza y gestiona todos
            <br>
            los recursos de la empresa.
        </p>

        {{-- Mensaje de sesión --}}
        <x-auth-session-status
            class="text-center"
            :status="session('status')"
        />

        <x-passkey-verify />

        {{-- Formulario original de Laravel --}}
        <form
            method="POST"
            action="{{ route('login.store') }}"
            class="flex flex-col gap-5"
        >
            @csrf

            <flux:input
                name="email"
                :label="__('Correo electrónico')"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="Ingrese su correo electrónico"
            />

            <div class="relative">
                <flux:input
                    name="password"
                    :label="__('Contraseña')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Ingrese su contraseña')"
                    viewable
                />

                @if (Route::has('password.request'))
                    <div class="mt-2 text-right">
                        <flux:link
                            :href="route('password.request')"
                            wire:navigate
                        >
                            ¿Olvidaste tu contraseña?
                        </flux:link>
                    </div>
                @endif
            </div>

            <flux:checkbox
                name="remember"
                :label="__('Recordarme')"
                :checked="old('remember')"
            />

            <flux:button
                variant="primary"
                type="submit"
                class="w-full"
                data-test="login-button"
            >
                Iniciar sesión
            </flux:button>
        </form>

        {{-- Pie del panel --}}
        <div class="login-footer">
            <strong>THE GAME SRL</strong>
            <span class="login-footer-divider">|</span>
            <span>Santa Cruz de la Sierra - Bolivia</span>
        </div>

    </div>
</x-layouts::auth.card>
