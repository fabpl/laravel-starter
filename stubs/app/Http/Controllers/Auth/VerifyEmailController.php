<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class VerifyEmailController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, string $id, string $hash): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! hash_equals((string) $user->getKey(), $id)) {
            throw new AuthorizationException;
        }

        if (! hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            throw new AuthorizationException;
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended('/?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->intended('/?verified=1');
    }
}
