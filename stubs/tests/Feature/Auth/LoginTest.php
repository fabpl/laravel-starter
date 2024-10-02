<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Event;
use Livewire\Volt\Volt;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\get;

test('show login page', function () {
    get(route('login'))
        ->assertSuccessful()
        ->assertSeeVolt('pages.auth.login');
});

test('is redirected if already logged in', function () {
    $user = User::factory()->create();

    actingAs($user);

    get(route('login'))
        ->assertRedirect('/');
});

test('users can authenticate', function () {
    $user = User::factory()->create();

    $component = Volt::test('pages.auth.login')
        ->set('form.email', $user->email)
        ->set('form.password', 'password');

    $component->call('login');

    $component
        ->assertHasNoErrors()
        ->assertRedirect('/');

    assertAuthenticated();
});

test('required fields', function (string $field) {
    $payload = [
        'email' => 'test@example.com',
        'password' => 'password',
    ];

    $payload[$field] = '';

    $component = Volt::test('pages.auth.login')
        ->set('form.email', $payload['email'])
        ->set('form.password', $payload['password']);

    $component->call('login');

    $component->assertHasErrors(["form.{$field}"]);
})->with(['email', 'password']);

test('email must be valid', function () {
    $component = Volt::test('pages.auth.login')
        ->set('form.email', 'invalid-example.com')
        ->set('form.password', 'password');

    $component->call('login');

    $component->assertHasErrors(['form.email']);
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $component = Volt::test('pages.auth.login')
        ->set('form.email', $user->email)
        ->set('form.password', 'wrong-password');

    $component->call('login');

    $component
        ->assertHasErrors()
        ->assertNoRedirect();

    assertGuest();
});

test('users are rate limited', function () {
    Event::fake();

    $user = User::factory()->create();

    for ($i = 0; $i < 5; $i++) {
        $component = Volt::test('pages.auth.login')
            ->set('form.email', $user->email)
            ->set('form.password', 'wrong-password');

        $component->call('login');
    }

    $component = Volt::test('pages.auth.login')
        ->set('form.email', $user->email)
        ->set('form.password', 'wrong-password');

    $component->call('login');

    Event::assertDispatched(Lockout::class);
});
