@props([
    'for',
])

<label
    {{ $attributes->twMerge('text-sm font-medium text-gray-900 dark:text-white') }}
    for="{{ $for }}"
>
    {{ $slot }}
</label>
