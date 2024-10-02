@props([
    'name',
])

@error($name)
<p {{ $attributes->twMerge('text-sm text-danger-600 dark:text-danger-500') }}>
    {{ $message }}
</p>
@enderror
