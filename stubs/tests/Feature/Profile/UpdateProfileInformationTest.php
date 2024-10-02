<?php

declare(strict_types=1);

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

test('profile information can be updated', function () {
    $user = User::factory()->create();

    actingAs($user);

    $component = livewire('profile.update-profile-information-form')
        ->set('form.name', 'Test User')
        ->set('form.email', 'test@example.com');

    $component->call('update');

    $component
        ->assertHasNoErrors()
        ->assertNoRedirect();

    $user->refresh();

    $this->assertSame('Test User', $user->name);
    $this->assertSame('test@example.com', $user->email);
    $this->assertNull($user->email_verified_at);
});

test('required fields', function (string $field) {
    $user = User::factory()->create();

    actingAs($user);

    $payload = [
        'name' => 'Test User',
        'email' => 'test@example.com',
    ];

    $payload[$field] = '';

    $component = livewire('profile.update-profile-information-form')
        ->set('form.name', $payload['name'])
        ->set('form.email', $payload['email']);

    $component->call('update');

    $component->assertHasErrors(["form.{$field}"]);
})->with(['name', 'email']);

test('email must be valid', function () {
    $user = User::factory()->create();

    actingAs($user);

    $component = livewire('profile.update-profile-information-form')
        ->set('form.name', 'Test User')
        ->set('form.email', 'invalid-example.com');

    $component->call('update');

    $component->assertHasErrors(['form.email']);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    actingAs($user);

    $component = livewire('profile.update-profile-information-form')
        ->set('form.name', 'Test User')
        ->set('form.email', $user->email);

    $component->call('update');

    $component
        ->assertHasNoErrors()
        ->assertNoRedirect();

    $this->assertNotNull($user->refresh()->email_verified_at);
});
