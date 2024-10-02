<?php

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

middleware(['auth']);

name('profile.edit');
?>
<x-layouts.app>
    <section>
        <div class="mx-auto max-w-screen-xl px-4 py-8 pt-20 lg:grid lg:grid-cols-3 lg:gap-16 lg:px-6 lg:py-24 lg:pt-28 xl:gap-24">
            <header class="col-span-1 mb-8">
                <x-ui.typography.h2>
                    {{ trans('Profile Information') }}
                </x-ui.typography.h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ trans("Update your account's profile information and email address.") }}
                </p>
            </header>

            <div class="col-span-2">
                <x-ui.card>
                    <div class="p-6 sm:p-8">
                        <livewire:profile.update-profile-information-form/>
                    </div>
                </x-ui.card>
            </div>
        </div>
    </section>

    <section>
        <div class="mx-auto max-w-screen-xl px-4 py-8 lg:grid lg:grid-cols-3 lg:gap-16 lg:px-6 lg:py-24 xl:gap-24">
            <header class="col-span-1 mb-8">
                <x-ui.typography.h2>
                    {{ trans('Update Password') }}
                </x-ui.typography.h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ trans('Ensure your account is using a long, random password to stay secure.') }}
                </p>
            </header>

            <div class="col-span-2">
                <x-ui.card>
                    <div class="p-6 sm:p-8">
                        <livewire:profile.update-password-form/>
                    </div>
                </x-ui.card>
            </div>
        </div>
    </section>

    <section>
        <div class="mx-auto max-w-screen-xl px-4 py-8 lg:grid lg:grid-cols-3 lg:gap-16 lg:px-6 lg:py-24 xl:gap-24">
            <header class="col-span-1 mb-8">
                <x-ui.typography.h2>
                    {{ trans('Delete Account') }}
                </x-ui.typography.h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ trans('Permanently delete your account.') }}
                </p>
            </header>

            <div class="col-span-2">
                <x-ui.card>
                    <div class="p-6 sm:p-8">
                        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ trans('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                        </div>

                        <livewire:profile.delete-account-form/>
                    </div>
                </x-ui.card>
            </div>
        </div>
    </section>
</x-layouts.app>
