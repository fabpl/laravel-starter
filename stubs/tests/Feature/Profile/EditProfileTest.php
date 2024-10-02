<?php

declare(strict_types=1);

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('show profile page', function () {
    $user = User::factory()->create();

    actingAs($user);

    get(route('profile.edit'))
        ->assertSuccessful()
        ->assertSeeLivewire('profile.update-profile-information-form')
        ->assertSeeLivewire('profile.update-password-form')
        ->assertSeeLivewire('profile.delete-account-form');
});
