<?php

use App\Livewire\Forms\Auth\RegisterForm;
use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Livewire\Volt\form;

form(RegisterForm::class);

middleware('guest');

name('register');

$register = function () {
    $this->form->submit();

    $this->redirect('/');
};
?>
<x-layouts.auth title="{{ trans('Register') }}">
    <div class="p-6 space-y-4 sm:p-8 md:space-y-6">
        <x-ui.typography.h1>
            {{ trans('Create an account') }}
        </x-ui.typography.h1>

        @volt('pages.auth.register')
        <x-ui.form wire:submit="register">
            <x-ui.form.field>
                <x-ui.form.label for="input-name">
                    {{ trans('Name') }}
                </x-ui.form.label>

                <x-ui.form.input
                    autofocus
                    id="input-name"
                    name="name"
                    required
                    type="text"
                    wire:model='form.name'
                />

                <x-ui.form.error name="form.name"/>
            </x-ui.form.field>

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

            <x-ui.form.field>
                <x-ui.form.checkbox
                    aria-describedby="terms"
                    id="checkbox-terms"
                    name="terms"
                    wire:model='form.terms'
                >
                    {!! trans('I agree to the :terms_of_service and :privacy_policy', [
                        'terms_of_service' => '<a target="_blank" href="'.route('terms').'" class="font-medium text-primary-600 hover:underline dark:text-primary-500">'.trans('Terms of Service').'</a>',
                        'privacy_policy' => '<a target="_blank" href="'.route('policy').'" class="font-medium text-primary-600 hover:underline dark:text-primary-500">'.trans('Privacy Policy').'</a>',
                    ]) !!}
                </x-ui.form.checkbox>

                <x-ui.form.error name="form.terms"/>
            </x-ui.form.field>

            <x-ui.button class="w-full" type="submit" wire:loading.attr="disabled">
                {{ trans('Sign up') }}
            </x-ui.button>
        </x-ui.form>
        @endvolt
    </div>
</x-layouts.auth>
