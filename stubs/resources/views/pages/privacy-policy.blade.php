<?php

use Illuminate\Support\Str;
use function Laravel\Folio\name;
use function Livewire\Volt\computed;

name('policy');

$policy = computed(fn() => Str::markdown(file_get_contents(resource_path('markdown/policy.md'))));
?>
<x-layouts.app>
    <section>
        <div class="mx-auto max-w-screen-xl px-4 py-8 pt-20 lg:px-6 lg:py-24 lg:pt-28">
            @volt('pages.policy')
                <div class="mx-auto prose dark:prose-invert text-gray-600 dark:text-gray-400">
                    {!! $this->policy !!}
                </div>
            @endvolt
        </div>
    </section>
</x-layouts.app>
