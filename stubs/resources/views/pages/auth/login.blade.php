<?php

use App\Livewire\Forms\Auth\LoginForm;
use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Livewire\Volt\form;

form(LoginForm::class);

middleware('guest');

name('login');

$login = function () {
    $this->form->submit();

    $this->redirectIntended(default: url('/'), navigate: true);
};
?>
<x-layouts.auth title="{{ trans('Login') }}">
    <div class="p-6 space-y-4 sm:p-8 md:space-y-6">
        <x-ui.typography.h2>
            {{ trans('Sign in to your account') }}
        </x-ui.typography.h2>

        @volt('pages.auth.login')
        <x-ui.form wire:submit="login">
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

            <div class="flex items-center justify-between">
                <x-ui.form.checkbox
                    aria-describedby="remember"
                    id="checkbox-remember"
                    name="remember"
                    wire:model='form.remember'
                >
                    {{ trans('Remember me') }}
                </x-ui.form.checkbox>

                <x-ui.typography.link :href="route('password.request')" class="text-sm">
                    {{ trans('Forgot password?') }}
                </x-ui.typography.link>
            </div>

            <x-ui.button class="w-full" type="submit" wire:loading.attr="disabled">
                {{ trans('Sign in') }}
            </x-ui.button>

            <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                {{ trans("Don't have an account yet?") }}
                <x-ui.typography.link :href="route('register')">
                    {{ trans('Sign up') }}
                </x-ui.typography.link>
            </p>
        </x-ui.form>
        @endvolt
    </div>
</x-layouts.auth>
