@props([
    'href',
])

<a
    {{ $attributes->twMerge('font-medium text-primary-600 hover:underline dark:text-primary-500') }}
    href="{{ $href }}"
    wire:navigate
>
    {{ $slot }}
</a>
