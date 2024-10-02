@props([
    'href' => null,
    'size' => 'base',
    'type' => 'button',
    'variant' => 'primary',
])

@php
    $classes = [
        'inline-flex items-center justify-center rounded-lg font-medium focus:outline-none focus:ring-4',
        match($size) {
            'icon' => 'p-2.5 text-sm',
            'xs' => 'px-3 py-2 text-xs',
            'sm' => 'px-3 py-2 text-sm',
            'lg' => 'px-5 py-3 text-base',
            'xl' => 'px-6 py-3.5 text-base',
            default => 'px-5 py-2.5 text-sm',
        },
        match($variant) {
            'danger' => 'bg-danger-700 text-sm text-white hover:bg-danger-800 focus:ring-danger-300 dark:bg-danger-600 dark:hover:bg-danger-700 dark:focus:ring-danger-900',
            'secondary' => 'border border-gray-200 bg-white text-sm text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700',
            'ghost' => 'text-gray-900 hover:bg-gray-100 focus:ring-gray-100 dark:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700',
            default => 'bg-primary-700 text-sm text-white hover:bg-primary-800 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800',
        }
    ];

    $tag = match($href) {
        null => 'button',
        default => 'a',
    };
@endphp

@if(filled($href))
    <a
        {{ $attributes->twMerge($classes) }}
        href="{{ $href }}"
        wire:navigate
    >
        {{ $slot }}
    </a>
@else
    <button
        {{ $attributes->twMerge($classes) }}
        type="{{ $type }}"
    >
        {{ $slot }}
    </button>
@endif
