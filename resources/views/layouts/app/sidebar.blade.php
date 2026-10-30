<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>

                    @can('Listado de Roles')
                        <flux:navlist.item icon="shield-check" :href="route('admin.roles.index')"
                            :current="request()->routeIs('admin.roles.index')" wire:navigate>Roles
                        </flux:navlist.item>
                    @endcan

                    @can('Listado de Usuarios')
                        <flux:navlist.item icon="users" :href="route('admin.usuarios.index')"
                            :current="request()->routeIs('admin.usuarios.index')" wire:navigate>Usuarios
                        </flux:navlist.item>
                    @endcan

                    @can('Listado de Categorías')
                        <flux:navlist.item icon="tag" :href="route('admin.categorias.index')"
                            :current="request()->routeIs('admin.categorias.*')" wire:navigate>Categorías
                        </flux:navlist.item>
                    @endcan

                    @can('Listado de Productos')
                        <flux:navlist.item icon="cube" :href="route('admin.productos.index')"
                            :current="request()->routeIs('admin.productos.*')" wire:navigate>Productos
                        </flux:navlist.item>
                    @endcan
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <!-- Menú de usuario en escritorio con foto de perfil compacta y circular -->
            <flux:dropdown position="top" align="start" class="max-lg:hidden">
                <flux:sidebar.profile
                    :name="auth()->user()->name"
                    :initials="false"
                >
                    <x-slot:avatar>
                        @if(auth()->user()->foto_perfil)
                            <div class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center bg-zinc-700">
                                <img src="{{ asset('storage/' . auth()->user()->foto_perfil) }}" class="w-full h-full object-cover" alt="{{ auth()->user()->name }}">
                            </div>
                        @else
                            <div class="flex items-center justify-center w-8 h-8 bg-zinc-700 text-white rounded-full text-xs font-bold">
                                {{ auth()->user()->initials() }}
                            </div>
                        @endif
                    </x-slot:avatar>
                </flux:sidebar.profile>

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="false"
                    icon-trailing="chevron-down"
                >
                    <x-slot:avatar>
                        @if(auth()->user()->foto_perfil)
                            <img src="{{ asset('storage/' . auth()->user()->foto_perfil) }}" class="rounded-full object-cover w-full h-full" alt="{{ auth()->user()->name }}">
                        @else
                            <div class="flex items-center justify-center w-full h-full bg-zinc-700 text-white rounded-full text-xs font-bold">
                                {{ auth()->user()->initials() }}
                            </div>
                        @endif
                    </x-slot:avatar>
                </flux:profile>

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
