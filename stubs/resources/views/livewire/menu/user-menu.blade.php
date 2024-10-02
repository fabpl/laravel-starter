<?php

use App\Actions\Auth\Logout;

$logout = function (Logout $logout) {
    $logout();

    $this->redirect('/');
};
?>
<x-ui.dropdown
    placement="bottom-end"
    teleport
>
    <x-slot name="trigger">
        <x-ui.button size="icon" variant="ghost">
            <span class="sr-only">
                {{ trans('Open user menu') }}
            </span>

            <x-fwb-o-user class="h-5 w-5"/>
        </x-ui.button>
    </x-slot>

    <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
        <div>
            {{ auth()->user()->name }}
        </div>

        <div class="truncate font-medium">
            {{ auth()->user()->email }}
        </div>
    </div>

    <div class="py-2">
        <x-ui.dropdown.link :href="route('profile.edit')">
            {{ trans('Profile') }}
        </x-ui.dropdown.link>
    </div>

    <div class="py-2">
        <x-ui.dropdown.link href="#" wire:click="logout">
            {{ trans('Sign out') }}
        </x-ui.dropdown.link>
    </div>
</x-ui.dropdown>
