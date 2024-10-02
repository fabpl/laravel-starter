<?php

declare(strict_types=1);

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

test('user can delete their account', function () {
    $user = User::factory()->create();

    actingAs($user);

    $component = livewire('profile.delete-account-form')
        ->set('form.current_password', 'password');

    $component->call('delete');

    $component
        ->assertHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($user->fresh());
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    actingAs($user);

    $component = livewire('profile.delete-account-form')
        ->set('form.current_password', 'wrong-password');

    $component->call('delete');

    $component->assertHasErrors(['form.current_password']);
});
