<?php

use App\Livewire\Forms\Profile\DeleteAccountForm;
use function Livewire\Volt\form;

form(DeleteAccountForm::class);

$delete = function () {
    $this->form->submit();

    $this->dispatch('toast',
        message: trans('Account deleted.'),
    );

    $this->redirect('/');
};
?>
<div>
    <x-ui.button
        variant="danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        {{ trans('Delete') }}
    </x-ui.button>

    <x-ui.modal name="confirm-user-deletion">
        <x-ui.modal.header>
            <x-ui.typography.h3>
                {{ trans('Delete Account') }}
            </x-ui.typography.h3>
        </x-ui.modal.header>

        <x-ui.modal.content>
            <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                {{ trans('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <x-ui.form wire:submit="delete">
                <x-ui.form.field>
                    <x-ui.form.label for="input-current-password">
                        {{ trans('Current Password') }}
                    </x-ui.form.label>

                    <x-ui.form.input
                        id="input-current-password"
                        name="current_password"
                        placeholder="••••••••"
                        required
                        type="password"
                        wire:model='form.current_password'
                    />

                    <x-ui.form.error name="form.current_password"/>
                </x-ui.form.field>

                <x-ui.button type="submit" variant="danger" wire:loading.attr="disabled">
                    {{ trans('Delete') }}
                </x-ui.button>
            </x-ui.form>
        </x-ui.modal.content>
    </x-ui.modal>
</div>
