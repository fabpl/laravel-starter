<?php

use App\Livewire\Forms\Profile\PasswordForm;
use function Livewire\Volt\form;

form(PasswordForm::class);

$update = function () {
    $this->form->submit();

    $this->dispatch('toast',
        message: trans('Password updated.'),
    );
};
?>
<x-ui.form wire:submit="update">
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

    <x-ui.form.field>
        <x-ui.form.label for="input-password">
            {{ trans('Password') }}
        </x-ui.form.label>

        <x-ui.form.input
            id="input-password"
            name="password"
            placeholder="••••••••"
            required
            type="password"
            wire:model='form.password'
        />

        <x-ui.form.error name="form.password"/>
    </x-ui.form.field>

    <x-ui.form.field>
        <x-ui.form.label for="input-password-confirmation">
            {{ trans('Confirm Password') }}
        </x-ui.form.label>

        <x-ui.form.input
            id="input-password-confirmation"
            name="password_confirmation"
            placeholder="••••••••"
            required
            type="password"
            wire:model='form.password_confirmation'
        />

        <x-ui.form.error name="form.password_confirmation"/>
    </x-ui.form.field>

    <x-ui.button type="submit" wire:loading.attr="disabled">
        {{ trans('Save') }}
    </x-ui.button>
</x-ui.form>
