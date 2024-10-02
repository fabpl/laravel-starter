<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Volt\Volt;

use function Pest\Laravel\get;

test('reset password screen can be rendered', function () {
    $user = User::factory()->create();

    $token = Str::random();

    DB::table('password_reset_tokens')->insert([
        'email' => $user->email,
        'token' => Hash::make($token),
        'created_at' => now(),
    ]);

    get(route('password.reset', ['token' => $token]))
        ->assertSuccessful()
        ->assertSeeVolt('pages.auth.password.reset');
});

test('can reset password', function () {
    $user = User::factory()->create();

    $token = Str::random();

    DB::table('password_reset_tokens')->insert([
        'email' => $user->email,
        'token' => Hash::make($token),
        'created_at' => now(),
    ]);

    $component = Volt::test('pages.auth.password.reset', [
        'token' => $token,
    ])
        ->set('form.email', $user->email)
        ->set('form.password', 'new-password')
        ->set('form.password_confirmation', 'new-password');

    $component->call('resetPassword');

    $component
        ->assertHasNoErrors()
        ->assertRedirect(route('login'));

    $user->refresh();

    expect(Hash::check('new-password', $user->password))->toBeTrue();
});

test('required fields', function (string $field) {
    $user = User::factory()->create();

    $token = Str::random();

    DB::table('password_reset_tokens')->insert([
        'email' => $user->email,
        'token' => Hash::make($token),
        'created_at' => now(),
    ]);

    $payload = [
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $payload[$field] = '';

    $component = Volt::test('pages.auth.password.reset', [
        'token' => Str::random(),
    ])
        ->set('form.email', $payload['email'])
        ->set('form.password', $payload['password'])
        ->set('form.password_confirmation', $payload['password_confirmation']);

    $component->call('resetPassword');

    $component->assertHasErrors(["form.{$field}"]);
})->with(['email', 'password', 'password_confirmation']);

test('email must be valid', function () {
    $user = User::factory()->create();

    $token = Str::random();

    DB::table('password_reset_tokens')->insert([
        'email' => $user->email,
        'token' => Hash::make($token),
        'created_at' => now(),
    ]);

    $component = Volt::test('pages.auth.password.reset', [
        'token' => Str::random(),
    ])
        ->set('form.email', 'invalid-example.com')
        ->set('form.password', 'new-password')
        ->set('form.password_confirmation', 'new-password');

    $component->call('resetPassword');

    $component->assertHasErrors(['form.email']);
});

test('password must be confirmed', function () {
    $user = User::factory()->create();

    $token = Str::random();

    DB::table('password_reset_tokens')->insert([
        'email' => $user->email,
        'token' => Hash::make($token),
        'created_at' => now(),
    ]);

    $component = Volt::test('pages.auth.password.reset', [
        'token' => Str::random(),
    ])
        ->set('form.email', $user->email)
        ->set('form.password', 'new-password')
        ->set('form.password_confirmation', 'wrong-password');

    $component->call('resetPassword');

    $component->assertHasErrors(['form.password']);
});

test('password must be at least 8 characters', function () {
    $user = User::factory()->create();

    $token = Str::random();

    DB::table('password_reset_tokens')->insert([
        'email' => $user->email,
        'token' => Hash::make($token),
        'created_at' => now(),
    ]);

    $component = Volt::test('pages.auth.password.reset', [
        'token' => Str::random(),
    ])
        ->set('form.email', $user->email)
        ->set('form.password', 'pass')
        ->set('form.password_confirmation', 'pass');

    $component->call('resetPassword');

    $component->assertHasErrors(['form.password']);
});
