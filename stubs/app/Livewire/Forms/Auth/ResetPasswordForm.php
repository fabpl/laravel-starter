<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Form;

final class ResetPasswordForm extends Form
{
    #[Locked]
    public string $token = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * @return array<string, array<int, PasswordRule|string>>
     */
    public function rules(): array
    {
        return [
            'password' => [
                'required',
                'string',
                'max:255',
                PasswordRule::default(),
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
     * Update the user's password.
     *
     * @throws ValidationException
     */
    public function submit(): void
    {
        $this->validate();

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ]);

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'form.email' => trans($status),
            ]);
        }
    }
}
