<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Auth;

use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

final class ForgotPasswordForm extends Form
{
    #[Validate('required|string|email')]
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     *
     * @throws ValidationException
     */
    public function submit(): void
    {
        $this->validate();

        Password::sendResetLink($this->only('email'));

        $this->reset('email');
    }
}
