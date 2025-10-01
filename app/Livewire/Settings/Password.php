<?php

namespace App\Livewire\Settings;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Password extends Component
{
    public string $current_pin = '';

    public string $pin = '';

    public string $password_pin = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePin(): void
    {
        try {
            $validated = $this->validate([
                'current_pin' => ['required', 'string', 'current_pin'],
                'pin' => ['required', 'string', PasswordRule::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_pin', 'pin', 'pin_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'pin' => Hash::make($validated['pin']),
        ]);

        $this->reset('current_pin', 'pin', 'pin_confirmation');

        $this->dispatch('pin-updated');
    }
}
