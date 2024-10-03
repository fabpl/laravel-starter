<x-layouts.app>
    <section class="bg-white dark:bg-gray-900">
        <div class="mx-auto grid max-w-screen-xl px-4 pt-20 pb-8 lg:grid-cols-12 lg:gap-8 lg:py-16 lg:pt-28 xl:gap-0">
            <div class="mr-auto place-self-center lg:col-span-7">
                <x-ui.typography.h1 class="mb-4">
                    Lorem ipsum dolor<br />sit amet.
                </x-ui.typography.h1>

                <p class="mb-6 max-w-2xl font-light text-gray-500 dark:text-gray-400 md:text-lg lg:mb-8 lg:text-xl">
                    Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>

                <x-ui.button as="a" :href="route('login')">
                    {{ trans('Get Started') }}
                    <x-fwb-o-arrow-right class="ms-2 h-4 w-4"/>
                </x-ui.button>
            </div>

            <div class="hidden lg:col-span-5 lg:mt-0 lg:flex">
                <x-fwb-o-image class="h-full w-full"/>
            </div>
        </div>
    </section>
</x-layouts.app>
