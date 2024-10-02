@props([
    'name',
    'show' => false,
    'maxWidth' => '2xl'
])

@php
    $name = $name ?? md5($attributes->wire('model'));

    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
    ][$maxWidth ?? '2xl'];
@endphp

<div>
    @teleport('body')
    <div
        class="fixed inset-0 flex items-center justify-center overflow-y-auto px-4 py-6 z-99 sm:px-0"
        style="display: none;"
        @if($attributes->has('wire:model'))
            x-data="{ show: @entangle($attributes->wire('model')) }"
        @else
            x-data="{ show: @js($show) }"
        @endif
        x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
        x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null"
        x-on:close.stop="show = false"
        x-on:keydown.escape.window="show = false"
        x-show="show"
    >
        <div
            class="fixed inset-0 transform transition-all"
            x-show="show"
            x-on:click="show = false"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <div class="absolute inset-0 bg-gray-500 opacity-75 dark:bg-gray-900"></div>
        </div>

        <div
            class="mb-6 bg-white dark:bg-gray-700 rounded-lg overflow-hidden shadow transform transition-all sm:w-full sm:mx-auto {{ $maxWidth }}"
            x-show="show"
            x-trap.inert.noscroll="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
            {{ $slot }}
        </div>
    </div>
    @endteleport
</div>
