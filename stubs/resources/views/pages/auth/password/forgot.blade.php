<?php

use App\Livewire\Forms\Auth\ForgotPasswordForm;
use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Livewire\Volt\form;

form(ForgotPasswordForm::class);

middleware('guest');

name('password.request');

$sendPasswordResetLink = function () {
    $this->form->submit();

    $this->dispatch('toast',
        message: trans('If the email exists in our system, we will send you an email with instructions to reset your password.'),
    );
};
?>
<x-layouts.auth title="{{ trans('Forgot Password?') }}">
    <div class="p-6 space-y-4 sm:p-8 md:space-y-6">
        <x-ui.typography.h2>
            {{ trans('Forgot Password?') }}
        </x-ui.typography.h2>

        @volt('pages.auth.password.request')
        <x-ui.form wire:submit="sendPasswordResetLink">
            <x-ui.form.field>
                <x-ui.form.label for="input-email">
                    {{ trans('Email') }}
                </x-ui.form.label>

                <x-ui.form.input
                    autofocus
                    id="input-email"
                    name="email"
                    placeholder="name@company.com"
                    required
                    type="email"
                    wire:model='form.email'
                />

                <x-ui.form.error name="form.email"/>
            </x-ui.form.field>

            <x-ui.button class="w-full" type="submit" wire:loading.attr="disabled">
                {{ trans('Send email reset link') }}
            </x-ui.button>
        </x-ui.form>
        @endvolt
    </div>
</x-layouts.auth>
