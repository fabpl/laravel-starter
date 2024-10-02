<?php

declare(strict_types=1);

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions\DeleteAction;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

it('show users page', function () {
    $user = User::factory()->create();

    actingAs($user);

    get(UserResource::getUrl())
        ->assertSuccessful();
});

it('can list users', function () {
    $user = User::factory()->create();

    actingAs($user);

    $users = User::factory()->count(9)->create();

    livewire(UserResource\Pages\ListUsers::class)
        ->assertCanSeeTableRecords($users);

    livewire(UserResource\Widgets\UserStatsOverview::class)
        ->assertSee('10');
});

it('show create users page', function () {
    $user = User::factory()->create();

    actingAs($user);

    get(UserResource::getUrl('create'))
        ->assertSuccessful();
});

it('can create users', function () {
    $user = User::factory()->create();

    actingAs($user);

    $newData = User::factory()->make();

    $component = livewire(UserResource\Pages\CreateUser::class)
        ->fillForm([
            'name' => $newData->name,
            'email' => $newData->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

    $component->call('create');

    $component->assertHasNoFormErrors();

    $this->assertDatabaseHas(User::class, [
        'email' => $newData->email,
    ]);
});

it('show edit users page', function () {
    $user = User::factory()->create();

    actingAs($user);

    get(UserResource::getUrl('edit', ['record' => User::factory()->create()]))
        ->assertSuccessful();
});

it('can retrieve data on user edit page', function () {
    $user = User::factory()->create();

    actingAs($user);

    $record = User::factory()->create();

    livewire(UserResource\Pages\EditUser::class, [
        'record' => $record->getRouteKey(),
    ])
        ->assertFormSet([
            'name' => $record->name,
            'email' => $record->email,
        ]);
});

it('can edit user', function () {
    $user = User::factory()->create();

    actingAs($user);

    $record = User::factory()->create();
    $newData = User::factory()->make();

    livewire(UserResource\Pages\EditUser::class, [
        'record' => $record->getRouteKey(),
    ])
        ->fillForm([
            'name' => $newData->name,
            'email' => $newData->email,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($record->refresh())
        ->name->toBe($newData->name)
        ->email->toBe($newData->email);
});

it('can delete user', function () {
    $user = User::factory()->create();

    actingAs($user);

    $record = User::factory()->create();

    livewire(UserResource\Pages\EditUser::class, ['record' => $record->getRouteKey()])
        ->callAction(DeleteAction::class);

    $this->assertModelMissing($record);
});
