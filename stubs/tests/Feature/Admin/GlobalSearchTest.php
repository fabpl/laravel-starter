<?php

declare(strict_types=1);

use App\Models\User;
use Filament\Livewire\GlobalSearch;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('can search users', function () {
    $user = User::factory()->create();

    actingAs($user);

    livewire(GlobalSearch::class)
        ->set('search', $user->name)
        ->call('getResults')
        ->assertSee($user->email);
});
