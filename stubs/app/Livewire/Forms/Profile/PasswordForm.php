<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

final class PasswordForm extends Form
{
    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * @return array<string, array<int, Password|string>>
     */
    public function rules(): array
    {
        return [
            'current_password' => [
                'required',
                'string',
                'current_password',
            ],
            'password' => [
                'required',
                'string',
                'max:255',
                Password::default(),
                'confirmed',
            ],
            'password_confirmation' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }

    /**
     * Attempt to update user password.
     *
     * @throws ValidationException
     */
    public function submit(): void
    {
        $this->validate();

        /** @var User $user */
        $user = auth()->user();

        $user->forceFill([
            'password' => Hash::make($this->password),
            'remember_token' => Str::random(60),
        ]);

        $user->save();

        $this->reset();
    }
}
