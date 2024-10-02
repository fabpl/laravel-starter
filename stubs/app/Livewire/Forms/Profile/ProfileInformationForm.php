<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Profile;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

final class ProfileInformationForm extends Form
{
    public string $name = '';

    public string $email = '';

    /**
     * @return array<string, array<int, Unique|string>>
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
                Rule::unique('users', 'email')->ignore(auth()->id()),
            ],
        ];
    }

    /**
     * Attempt to update user profile information.
     *
     * @throws ValidationException
     */
    public function submit(): void
    {
        $this->validate();

        /** @var User $user */
        $user = auth()->user();

        $user->fill([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
    }
}
