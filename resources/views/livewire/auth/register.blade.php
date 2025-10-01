<div class="flex flex-col gap-6" x-data="{
    step: @entangle('step'),
    pin: @entangle('pin').defer,
    pin_confirmation: @entangle('pin_confirmation').defer
}">
<x-auth-header 
    :title="
        $step === 1 ? __('Create an account') : 
        ($step === 2 ? __('Set your PIN') : __('Confirm your PIN'))
    " 
    :description="
        $step === 1 ? __('Enter your details below to create your account') : 
        ($step === 2 ? __('Enter a 6-digit PIN to secure your account') : 
        __('Confirm your 6-digit PIN to proceed'))
    " 
/>

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit.prevent="submitStep" novalidate class="flex flex-col gap-6">
        <div x-show="step === 1" class="flex flex-col gap-5">
            <!-- Step 1: Name and Email -->


            <flux:field>
                <flux:label>Username</flux:label>

                <flux:input wire:model.defer="name" type="text" required autofocus
                    autocomplete="name" :placeholder="__('Full name')" />
                <flux:error name="name" />
            </flux:field>

            <flux:field>
                <flux:label>Email</flux:label>

            <flux:input wire:model.defer="email" type="email" required
                autocomplete="email" placeholder="email@example.com" />
                <flux:error name="email" />
            </flux:field> 

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">
                    {{ __('Next') }}
                </flux:button>
            </div>
        </div>


        <div x-show="step === 2" class="flex flex-col gap-5">
            <div class="  relative  " x-data="{ pin: @entangle('pin') }"> 

                <input x-ref="pinInput" type="text" maxlength="6" inputmode="numeric" autocomplete="one-time-code"
                    class="opacity-0 absolute left-0 top-0 w-full h-12" x-model="pin" wire:model="pin" autofocus />

                <div tabindex="0" x-on:click="$refs.pinInput.focus()"
                    class="flex justify-between cursor-text select-none "
                    style="user-select: none;">
                    <template x-for="(digit, index) in 6" :key="index">
                        <div class="w-12 h-12 border-2 rounded flex items-center justify-center text-xl  "
                            :class="{
                                'border-blue-500': pin.length === index || (pin.length === 6 && index === 5),
                                'border-gray-300': !(pin.length === index || (pin.length === 6 && index === 5))
                            }">
                            <span x-text="pin[index] || ''"></span>
                        </div>
                    </template>
                </div>
            </div>
            <div class="flex justify-between">
                <flux:button type="button" variant="danger" wire:click="previousStep">
                    {{ __('Back') }}
                </flux:button>
 
            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">
                    {{ __('Next') }}
                </flux:button>
            </div>
            </div>
        </div>

        
        <div x-show="step === 3" class="flex flex-col gap-5">
            <div class="  relative  " x-data="{ pin_confirmation: @entangle('pin_confirmation') }"> 

                <input x-ref="pinCInput" type="text" maxlength="6" inputmode="numeric" autocomplete="one-time-code"
                    class="opacity-0 absolute left-0 top-0 w-full h-12" x-model="pin_confirmation" wire:model="pin_confirmation" autofocus />

                <div tabindex="0" x-on:click="$refs.pinCInput.focus()"
                    class="flex justify-between cursor-text select-none "
                    style="user-select: none;">
                    <template x-for="(digit, index) in 6" :key="index">
                        <div class="w-12 h-12 border-2 rounded flex items-center justify-center text-xl  "
                            :class="{
                                'border-blue-500': pin_confirmation.length === index || (pin_confirmation.length === 6 && index === 5),
                                'border-gray-300': !(pin_confirmation.length === index || (pin_confirmation.length === 6 && index === 5))
                            }">
                            <span x-text="pin_confirmation[index] || ''"></span>
                        </div>
                    </template>
                </div>
            </div>
            <div class="flex justify-between">
                <flux:button type="button" variant="danger" wire:click="previousStep">
                    {{ __('Back') }}
                </flux:button>

                <flux:button type="submit" variant="primary">
                    {{ __('Create account') }}
                </flux:button>
            </div>
        </div>
    </form>

    @if ($step === 1)
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Already have an account?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
        </div>
    @endif

</div>
