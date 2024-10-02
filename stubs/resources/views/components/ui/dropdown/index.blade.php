@props([
    'width' => '48',
])

@php
    $classes = [
        'z-10 hidden rounded-lg bg-white shadow divide-y divide-gray-100 dark:divide-gray-600 dark:bg-gray-700',
        match ($width) {
            '60' => 'w-60',
            default => 'w-48',
        }
    ];
@endphp

<div
    x-data="{
        toggle: function (event) {
            $refs.dropdown.toggle(event)
        },

        open: function (event) {
            $refs.dropdown.open(event)
        },

        close: function (event) {
            $refs.dropdown.close(event)
        },
    }"
>
    <div class="cursor-pointer" x-on:click="toggle">
        {{ $trigger }}
    </div>

    <div
        {{ $attributes->twMerge($classes) }}
        x-cloak
        x-float.placement.bottom-end.flip.teleport.offset="{ offset: 8 }"
        x-ref="dropdown"
        x-transition:enter-start="opacity-0"
        x-transition:leave-end="opacity-0"
    >
        {{ $slot }}
    </div>
</div>
