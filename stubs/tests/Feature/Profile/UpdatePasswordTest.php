<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

test('password can be updated', function () {
    $user = User::factory()->create();

    actingAs($user);

    $component = livewire('profile.update-password-form')
        ->set('form.current_password', 'password')
        ->set('form.password', 'new-password')
        ->set('form.password_confirmation', 'new-password');

    $component->call('update');

    $component
        ->assertHasNoErrors()
        ->assertNoRedirect();

    $user->refresh();

    $this->assertTrue(Hash::check('new-password', $user->password));
});

test('required fields', function (string $field) {
    $user = User::factory()->create();

    actingAs($user);

    $payload = [
        'current_password' => 'password',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $payload[$field] = '';

    $component = livewire('profile.update-password-form')
        ->set('form.current_password', $payload['current_password'])
        ->set('form.password', $payload['password'])
        ->set('form.password_confirmation', $payload['password_confirmation']);

    $component->call('update');

    $component->assertHasErrors(["form.{$field}"]);
})->with(['current_password', 'password', 'password_confirmation']);

test('correct password must be provided to update password', function () {
    $user = User::factory()->create();

    actingAs($user);

    $component = livewire('profile.update-password-form')
        ->set('form.current_password', 'wrong-password')
        ->set('form.password', 'new-password')
        ->set('form.password_confirmation', 'new-password');

    $component->call('update');

    $component->assertHasErrors(['form.current_password']);
});
