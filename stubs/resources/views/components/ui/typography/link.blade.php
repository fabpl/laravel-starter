@props([
    'href',
    'size' => 'base',
    'variant' => 'primary',
])

@php
    $classes = [
        'font-medium hover:underline',
        match($size) {
            'xs' => 'text-xs',
            'sm' => 'text-sm',
            default => 'text-base',
        },
        match($variant) {
            'secondary' => 'text-gray-900 hover:text-primary-700 dark:text-gray-400 dark:hover:text-white',
            default => 'text-primary-600 dark:text-primary-500',
        }
    ];
@endphp

<a
    {{ $attributes->twMerge($classes) }}
    href="{{ $href }}"
    wire:navigate
>
    {{ $slot }}
</a>
