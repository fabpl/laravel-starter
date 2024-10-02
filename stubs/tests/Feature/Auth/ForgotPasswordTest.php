<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Livewire\Volt\Volt;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('reset password screen can be rendered', function () {
    get(route('password.request'))
        ->assertSuccessful()
        ->assertSeeVolt('pages.auth.password.request');
});

test('is redirected if already logged in', function () {
    $user = User::factory()->create();

    actingAs($user);

    get(route('password.request'))
        ->assertRedirect('/');
});

test('reset password link can be requested', function () {
    Notification::fake();

    $user = User::factory()->create();

    $component = Volt::test('pages.auth.password.request')
        ->set('form.email', $user->email);

    $component->call('sendPasswordResetLink');

    $component->assertHasNoErrors();

    Notification::assertSentTo($user, ResetPassword::class);
});

test('required fields', function (string $field) {
    $payload = [
        'email' => 'test@example.com',
    ];

    $payload[$field] = '';

    $component = Volt::test('pages.auth.password.request')
        ->set('form.email', $payload['email']);

    $component->call('sendPasswordResetLink');

    $component->assertHasErrors(["form.{$field}"]);
})->with(['email']);

test('email must be valid', function () {
    $component = Volt::test('pages.auth.password.request')
        ->set('form.email', 'invalid-example.com')
        ->set('form.password', 'password');

    $component->call('sendPasswordResetLink');

    $component->assertHasErrors(['form.email']);
});
