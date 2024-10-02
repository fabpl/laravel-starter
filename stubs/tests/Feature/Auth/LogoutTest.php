<?php

declare(strict_types=1);

use App\Models\User;
use Livewire\Volt\Volt;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertGuest;

test('users can logout', function () {
    $user = User::factory()->create();

    actingAs($user);

    $component = Volt::test('menu.user-menu');

    $component->call('logout');

    $component
        ->assertHasNoErrors()
        ->assertRedirect('/');

    assertGuest();
});
