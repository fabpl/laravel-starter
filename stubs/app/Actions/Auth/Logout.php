<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

final class Logout
{
    /**
     * Log out the current user out of the application.
     */
    public function __invoke(): void
    {
        Auth::logout();

        Session::invalidate();
        Session::regenerateToken();
    }
}
