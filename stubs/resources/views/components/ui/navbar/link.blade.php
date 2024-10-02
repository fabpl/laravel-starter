@props([
    'active' => false,
    'href',
])

@php
    $classes = [
        'block py-2 pr-4 pl-3 lg:p-0',
        match($active) {
            true => 'rounded bg-primary-700 text-white dark:text-white lg:bg-transparent lg:text-primary-700',
            false => 'border-b border-gray-100 text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 lg:border-0 dark:hover:bg-gray-700 dark:hover:text-white lg:hover:bg-transparent lg:hover:text-primary-700 lg:dark:hover:bg-transparent lg:dark:hover:text-white',
        }
    ];
@endphp

<a
    {{ $active ? 'aria-current="page"' : '' }}
    {{ $attributes->twMerge($classes) }}
    href="{{ $href }}"
    wire:navigate
>
    {{ $slot }}
</a>
