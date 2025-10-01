<section class="w-full container mx-auto">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer"
                                wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>
            <!-- Foto de perfil -->
            <div>
                <flux:heading class="mt-4">
                    {{ __('Profile Picture') }}
                </flux:heading>

                <div class="mt-2 flex items-center gap-4">
                    <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : asset('images/default-avatar.png') }}"
                        class="w-20 h-20 rounded-full object-cover">
                        <flux:input type="file" wire:model="photo" />
                </div>
                @error('photo')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                @if ($photo)
                    <p class="mt-2 text-sm text-gray-500">Prévia:</p>
                    <img src="{{ $photo->temporaryUrl() }}" class="w-20 h-20 rounded-full object-cover">
                @endif
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
