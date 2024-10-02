<?php

use App\Livewire\Forms\Auth\ResetPasswordForm;
use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Livewire\Volt\form;
use function Livewire\Volt\mount;

form(ResetPasswordForm::class);

middleware('guest');

mount(function(string $token) {
    $this->form->email = request()->string('email')->value();
    $this->form->token = $token;
});

name('password.reset');

$resetPassword = function () {
    $this->form->submit();

    $this->dispatch('toast',
        message: trans('Your password has been reset.'),
    );

    $this->redirect(route('login'), navigate: true);
};
?>
<x-layouts.auth title="{{ trans('Reset Password') }}">
    <div class="p-6 space-y-4 sm:p-8 md:space-y-6">
        <x-ui.typography.h1>
            {{ trans('Reset password') }}
        </x-ui.typography.h1>

        @volt('pages.auth.password.reset')
        <x-ui.form wire:submit="resetPassword">
            <x-ui.form.field>
                <x-ui.form.label for="input-email">
                    {{ trans('Email') }}
                </x-ui.form.label>

                <x-ui.form.input
                    id="input-email"
                    name="email"
                    placeholder="name@company.com"
                    required
                    type="email"
                    wire:model='form.email'
                />

                <x-ui.form.error name="form.email"/>
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

            <x-ui.button class="w-full" type="submit" wire:loading.attr="disabled">
                {{ trans('Reset Password') }}
            </x-ui.button>
        </x-ui.form>
        @endvolt
    </div>
</x-layouts.auth>
