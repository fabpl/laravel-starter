<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Livewire\Volt\Volt;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('show verification page', function () {
    $user = User::factory()->unverified()->create();

    actingAs($user);

    get(route('verification.notice'))
        ->assertSuccessful()
        ->assertSeeVolt('pages.auth.verify');
});

test('can resend verification email', function () {
    Notification::fake();

    $user = User::factory()->create();

    actingAs($user);

    $component = Volt::test('pages.auth.verify');

    $component->call('resendVerificationEmail');

    Notification::assertSentTo($user, VerifyEmail::class);
});

test('can verify', function () {
    $user = User::factory()->unverified()->create();

    actingAs($user);

    $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(config('auth.verification.expire', 60)), [
        'id' => $user->getKey(),
        'hash' => sha1($user->getEmailForVerification()),
    ]);

    get($url)
        ->assertRedirect('/?verified=1');

    expect($user->hasVerifiedEmail())->toBeTrue();
});

test('email is not verified with invalid hash', function () {
    $user = User::factory()->unverified()->create();

    actingAs($user);

    $verificationUrl = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), [
        'id' => $user->id,
        'hash' => sha1('wrong-email'),
    ]);

    get($verificationUrl);

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});

test('email is not verified with invalid user id', function () {
    $user = User::factory()->unverified()->create();

    actingAs($user);

    $verificationUrl = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), [
        'id' => 123,
        'hash' => sha1($user->getEmailForVerification()),
    ]);

    get($verificationUrl);

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});

test('email is already verified', function () {
    $user = User::factory()->create();

    actingAs($user);

    $verificationUrl = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), [
        'id' => $user->getKey(),
        'hash' => sha1($user->getEmailForVerification()),
    ]);

    get($verificationUrl)
        ->assertRedirect('/?verified=1');
});
