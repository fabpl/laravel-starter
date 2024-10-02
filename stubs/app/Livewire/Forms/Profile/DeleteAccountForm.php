<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

final class DeleteAccountForm extends Form
{
    public string $current_password = '';

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'current_password' => [
                'required',
                'string',
                'current_password',
            ],
        ];
    }

    /**
     * Attempt to delete user.
     *
     * @throws ValidationException
     */
    public function submit(): void
    {

        $this->validate();

        /** @var User $user */
        $user = auth()->user();

        Auth::logout();

        Session::invalidate();
        Session::regenerateToken();

        $user->delete();
    }
}
