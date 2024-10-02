<?php

use App\Livewire\Forms\Profile\ProfileInformationForm;
use function Livewire\Volt\form;
use function Livewire\Volt\mount;

form(ProfileInformationForm::class);

mount(function () {
    $this->form->name = auth()->user()->name;
    $this->form->email = auth()->user()->email;
});

$update = function () {
    $this->form->submit();

    $this->dispatch('toast',
        message: trans('Profile updated!'),
    );
};
?>
<x-ui.form wire:submit="update">
    <x-ui.form.field>
        <x-ui.form.label for="input-name">
            {{ trans('Name') }}
        </x-ui.form.label>

        <x-ui.form.input
            autofocus
            id="input-name"
            name="name"
            required
            type="text"
            wire:model='form.name'
        />

        <x-ui.form.error name="form.name"/>
    </x-ui.form.field>

    <x-ui.form.field>
        <x-ui.form.label for="input-email">
            {{ trans('Email') }}
        </x-ui.form.label>

        <x-ui.form.input
            id="input-email"
            name="email"
            placeholder="name@company.com"
            required
            type="email"
            wire:model='form.email'
        />

        <x-ui.form.error name="form.email"/>
    </x-ui.form.field>

    <x-ui.button type="submit" wire:loading.attr="disabled">
        {{ trans('Save') }}
    </x-ui.button>
</x-ui.form>
