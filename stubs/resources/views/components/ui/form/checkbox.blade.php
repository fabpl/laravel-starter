@props([
    'id' => 'checkbox-'.uniqid(),
])

<div class="flex items-start">
    <div class="flex h-5 items-center">
        <input
            {{ $attributes->twMerge('h-4 w-4 rounded border border-gray-300 bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600') }}
            id="{{ $id }}"
            type="checkbox"
        >
    </div>

    <div class="ml-3 text-sm">
        <label for="{{ $id }}" class="text-gray-500 dark:text-gray-300">
            {{ $slot }}
        </label>
    </div>
</div>
