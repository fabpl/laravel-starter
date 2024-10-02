<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Console\PruneCommand;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('deletes non-verified users', function () {
    User::factory()
        ->count(3)
        ->state(new Sequence(
            ['email_verified_at' => now(), 'updated_at' => now()],
            ['email_verified_at' => null, 'updated_at' => now()->subDays(8)],
            ['email_verified_at' => null, 'updated_at' => now()->subHour()],
        ))
        ->create();

    $this
        ->artisan(PruneCommand::class, ['--model' => User::class])
        ->assertExitCode(0);

    expect(User::query()->count())->toBe(2);
});
