<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

final class RegisterForm extends Form
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public bool $terms = false;

    /**
     * @return array<string, array<int, Password|Unique|string>>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
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
            'terms' => [
                'boolean',
                'accepted',
            ],
        ];
    }

    /**
     * Attempt to create new user.
     *
     * @throws ValidationException
     */
    public function submit(): void
    {
        $this->validate();

        $user = User::query()->create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        event(new Registered($user));

        Auth::login($user);
    }
}
