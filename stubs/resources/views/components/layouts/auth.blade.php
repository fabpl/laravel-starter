<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? (string)config('app.name', 'Laravel') }}</title>

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900">

<div class="mx-auto flex flex-col items-center justify-center px-6 py-8 md:h-screen lg:py-0">
    <a
        class="mb-6 flex items-center text-2xl font-semibold text-gray-900 dark:text-white"
        href="{{ url('/') }}"
        wire:navigate
    >
        <x-fwb-o-layers class="mr-2 h-8 w-8"/>

        {{ (string)config('app.name', 'Laravel') }}
    </a>

    <x-ui.card class="w-full sm:max-w-md">
        {{ $slot }}
    </x-ui.card>
</div>

@persist('notifications')
@livewire('notifications.list-toasts')
@endpersist

@livewireScriptConfig
</body>
</html>
