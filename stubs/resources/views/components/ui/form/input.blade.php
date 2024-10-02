@props([
    'name',
    'type' => 'text',
])

<input
    {{ $attributes->twMerge([
        'rounded-lg border p-2.5',
        match(true) {
            $errors->has($name) => 'border-danger-500 bg-danger-50 text-danger-900 placeholder-danger-700 focus:border-danger-500 focus:ring-danger-500 dark:placeholder-danger-500 dark:border-danger-500 dark:text-danger-500',
            default => 'border-gray-300 bg-gray-50 text-gray-900 focus:ring-primary-600 focus:border-primary-600 dark:placeholder-gray-400 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-primary-500 dark:focus:ring-primary-500',
        }
    ]) }}
    name="{{ $name }}"
    type="{{ $type }}"
>
