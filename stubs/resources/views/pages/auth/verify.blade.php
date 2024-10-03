<?php

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

middleware(['auth', 'throttle:6,1']);

name('verification.notice');

$resendVerificationEmail = function () {
    /** @var User $user */
    $user = auth()->user();

    $user->sendEmailVerificationNotification();

    event(new Verified($user));

    $this->dispatch('toast',
        message: trans('A new verification link has been sent to the email address you provided during registration.'),
    );
};
?>
<x-layouts.auth title="{{ trans('Email Verification') }}">
    <div class="p-6 space-y-4 sm:p-8 md:space-y-6">
        <x-ui.typography.h2>
            {{ trans('Verify your email') }}
        </x-ui.typography.h2>

        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
            {{ trans("Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.") }}
        </p>

        @volt('pages.auth.verify')
        <x-ui.form wire:submit="resendVerificationEmail">
            <x-ui.button type="submit" variant="secondary" wire:loading.attr="disabled">
                {{ trans('Resend Verification Email') }}
            </x-ui.button>
        </x-ui.form>
        @endvolt
    </div>
</x-layouts.auth>
