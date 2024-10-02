<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Schedule;

Schedule::command('model:prune', ['--model' => [User::class]])->hourly();
