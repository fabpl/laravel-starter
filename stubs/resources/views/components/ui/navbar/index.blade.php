<nav
    class="border-gray-200 bg-white py-2.5 dark:bg-gray-900"
    x-data="{ open: false }"
>
    <div class="mx-auto flex max-w-screen-xl flex-wrap items-center justify-between px-4">
        <div>
            {{ $brand ?? '' }}
        </div>

        <div class="flex items-center gap-2 lg:order-2">
            {{ $actions ?? '' }}

            <x-ui.button
                class="lg:hidden"
                size="icon"
                variant="ghost"
                @click="open = ! open"
            >
                <span class="sr-only">{{ trans('Open main menu') }}</span>
                <x-fwb-o-bars class="h-5 w-5"/>
            </x-ui.button>
        </div>

        <div
            class="hidden w-full items-center justify-between lg:order-1 lg:flex lg:w-auto"
            :class="{'block': open, 'hidden': ! open}"
            x-transition:enter-start="opacity-0"
            x-transition:leave-end="opacity-0"
        >
            <div class="mt-4 flex flex-col font-medium lg:space-x-8 lg:mt-0 lg:flex-row">
                {{ $slot }}
            </div>
        </div>
    </div>
</nav>
