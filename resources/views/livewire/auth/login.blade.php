<div class="flex flex-col gap-6" x-data="{ pin: @entangle('pin').defer }">
    <x-auth-header :title="__('Log in to your account')" :description="$stepEmail ? __('Enter your email below to continue') : __('Enter your 6-digit PIN below to log in')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    @if ($stepEmail)
        <form wire:submit.prevent="loginEmail" class="flex flex-col gap-6">
            <flux:input wire:model.defer="email" :label="__('Email address')" type="email" required autofocus
                autocomplete="email" placeholder="email@example.com" />

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full">{{ __('Continue') }}</flux:button>
            </div>
        </form>
    @else
        <form wire:submit.prevent="loginPin" class="flex flex-col gap-6">

            <div class=" relative" x-data="{ pin: @entangle('pin') }">


                <input x-ref="pinInput" type="text" maxlength="6" inputmode="numeric" autocomplete="one-time-code"
                    class="opacity-0 absolute left-0 text-zinc-100  top-0 w-full h-12" x-model="pin" wire:model="pin" autofocus />

                <div tabindex="0" x-on:click="$refs.pinInput.focus()"
                    class="flex justify-between cursor-text select-none "
                    style="user-select: none;">
                    <template x-for="(digit, index) in 6" :key="index">
                        <div class="w-12 h-12 border-2  text-zinc-100  rounded flex items-center justify-center text-xl  "
                            :class="{
                                'border-accent': pin.length === index || (pin.length === 6 && index === 5),
                                'border-gray-300': !(pin.length === index || (pin.length === 6 && index === 5))
                            }">
                            <span x-text="pin[index] || ''"></span>
                        </div>
                    </template>
                </div>
            </div>



            <!-- Remember Me -->
            <flux:checkbox wire:model="remember" :label="__('Remember me')" />

             <div class="flex justify-between">
                <flux:button variant="danger" type="button" wire:click="$set('stepEmail', true)"
                    class="text-sm text-gray-600 hover:underline">
                    {{ __('Back to Email') }}
                </flux:button>
   <div class="flex justify-end">

                <flux:button variant="primary" type="submit" class="w-full max-w-xs">
                    {{ __('Log in') }}
                </flux:button>
            </div>
            </div>
        </form>
    @endif

    @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Don\'t have an account?') }}</span>
            <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
        </div>
    @endif
</div>
