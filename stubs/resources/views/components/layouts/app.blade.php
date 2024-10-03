<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? (string)config('app.name', 'Laravel') }}</title>

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-800">

<div class="flex min-h-screen flex-col">
    <header class="fixed w-full">
        <x-ui.navbar>
            <x-slot name="brand">
                <a href="{{ url('/') }}" class="flex items-center dark:text-white" wire:navigate>
                    <x-fwb-o-layers class="mr-3 h-6 w-6 sm:h-9"/>

                    <span class="self-center whitespace-nowrap text-xl font-semibold">
                        {{ (string)config('app.name', 'Laravel') }}
                    </span>
                </a>
            </x-slot>

            <x-slot name="actions">
                @auth
                    @livewire('menu.user-menu')
                @endauth

                @guest
                    <x-ui.button :href="route('login')" variant="ghost">
                        {{ trans('Log in') }}
                    </x-ui.button>

                    <x-ui.button :href="route('register')">
                        {{ trans('Register') }}
                    </x-ui.button>
                @endguest
            </x-slot>

            <x-ui.navbar.link :href="url('/')" :active="request()->is('/')">
                {{ trans('Home') }}
            </x-ui.navbar.link>
        </x-ui.navbar>
    </header>

    <main class="flex-1">
        {{ $slot }}
    </main>

    <footer class="bg-white dark:bg-gray-800">
        <div class="mx-auto max-w-screen-xl p-4 py-6 sm:flex sm:items-center sm:justify-between md:p-8 lg:p-10 lg:py-16">
            <p class="mb-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:mb-0">
                © {{ date('Y') }} {{ (string)config('app.name', 'Laravel') }}™. All Rights Reserved.
            </p>

            <div class="flex justify-center items-center space-x-2">
                <x-ui.typography.link size="sm" variant="secondary" :href="route('terms')">
                    {{ trans('Terms Of Service') }}
                </x-ui.typography.link>

                <x-ui.typography.link size="sm" variant="secondary" :href="route('policy')">
                    {{ trans('Privacy Policy') }}
                </x-ui.typography.link>
            </div>
        </div>
    </footer>
</div>

@persist('notifications')
@livewire('notifications.list-toasts')
@endpersist

@livewireScriptConfig
</body>
</html>
