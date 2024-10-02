<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Livewire\Volt\Volt;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\get;

test('registration screen can be rendered', function () {
    get(route('register'))
        ->assertSuccessful()
        ->assertSeeVolt('pages.auth.register');
});

test('is redirected if already logged in', function () {
    $user = User::factory()->create();

    actingAs($user);

    get(route('register'))
        ->assertRedirect('/');
});

test('new users can register', function () {
    Event::fake();

    $component = Volt::test('pages.auth.register')
        ->set('form.name', 'Test User')
        ->set('form.email', 'test@example.com')
        ->set('form.password', 'password')
        ->set('form.password_confirmation', 'password')
        ->set('form.terms', true);

    $component->call('register');

    Event::assertDispatched(Registered::class);

    $component->assertRedirect('/');

    assertAuthenticated();
});

test('required fields', function (string $field) {
    $payload = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $payload[$field] = '';

    $component = Volt::test('pages.auth.register')
        ->set('form.name', $payload['name'])
        ->set('form.email', $payload['email'])
        ->set('form.password', $payload['password'])
        ->set('form.password_confirmation', $payload['password_confirmation'])
        ->set('form.terms', true);

    $component->call('register');

    $component->assertHasErrors(["form.{$field}"]);
})->with(['name', 'email', 'password', 'password_confirmation']);

test('email must be valid', function () {
    $component = Volt::test('pages.auth.register')
        ->set('form.name', 'Test User')
        ->set('form.email', 'invalid-example.com')
        ->set('form.password', 'password')
        ->set('form.password_confirmation', 'password')
        ->set('form.terms', true);

    $component->call('register');

    $component->assertHasErrors(['form.email']);
});

test('password must be confirmed', function () {
    $component = Volt::test('pages.auth.register')
        ->set('form.name', 'Test User')
        ->set('form.email', 'test@example.com')
        ->set('form.password', 'password')
        ->set('form.password_confirmation', 'wrong-password')
        ->set('form.terms', true);

    $component->call('register');

    $component->assertHasErrors(['form.password']);
});

test('email must be unique', function () {
    User::factory()->create([
        'email' => 'test@example.com',
    ]);

    $component = Volt::test('pages.auth.register')
        ->set('form.name', 'Test User')
        ->set('form.email', 'test@example.com')
        ->set('form.password', 'password')
        ->set('form.password_confirmation', 'password')
        ->set('form.terms', true);

    $component->call('register');

    $component->assertHasErrors(['form.email']);
});

test('password must be at least 8 characters', function () {
    $component = Volt::test('pages.auth.register')
        ->set('form.name', 'Test User')
        ->set('form.email', 'test@example.com')
        ->set('form.password', 'pass')
        ->set('form.password_confirmation', 'pass')
        ->set('form.terms', true);

    $component->call('register');

    $component->assertHasErrors(['form.password']);
});
