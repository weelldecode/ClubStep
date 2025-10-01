<div class="mt-28">

    <div class="grid grid-cols-5 grid-rows-1 gap-28 ">
        <div class="col-span-2 ">

            <div class="absolute top-5 left-5 flex items-center justify-center  mb-5  gap-2">
                   <a href="{{ route('dashboard') }}"
                class="w-full ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0" wire:navigate>
                <x-app-logo />
            </a>

            </div>
            <div class=" py-5 flex flex-col gap-1" id="plan">

                <h1 class="font-medium text-xl tracking-wide text-zinc-600">{{ $plan->name }}</h1>
                <div class="flex items-center gap-3">
                    <h4 class="text-4xl font-semibold text-zinc-700 tracking-wide">R$ {{ $plan->price }}</h4>
                    <span class="w-10 font-medium text-sm text-zinc-500">Por Mês</span>
                </div>

                <div class="mt-16 flex flex-col justify-center gap-5">
                    <div>
                        <div class="flex justify-between items-center font-medium text-zinc-700 text-lg">
                            Plano: <span class="font-medium text-zinc-700"
                                data-name="{{ $plan->name }} ">{{ $plan->name }} </span>
                        </div>
                        <span class="text-sm font-light text-zinc-500 tracking-wide"> Faturado mensalmente</span>
                    </div>
                            <hr class="border border-zinc-100 dark:border-gray-200"> 
                    <div class="flex justify-between items-center font-medium text-zinc-700 text-lg">
                        Subtotal: <span class="font-medium text-zinc-700" data-price="{{ $plan->price }}">R$
                            {{ $plan->price }} </span></div>
                    <div class="flex justify-between items-center font-medium text-zinc-600 text-base">
                        Taxa: <span class="font-medium text-zinc-700">R$ 0,00</span></div>
                            <hr class="border border-zinc-100 dark:border-gray-200"> 
                    <div class="flex justify-between items-center font-semibold text-zinc-700 text-xl"> Total: <span
                            class="font-semibold text-zinc-700"> R$ {{ $plan->price }} </span></div>

                </div>

            </div>
        </div>
        <div class="col-span-3 col-start-3 bg-zinc-50 border border-zinc-200 dark:border-gray-200  rounded-md  ">
        <div 
        id="checkout-data"
        data-plan-price="{{ $plan->price }}"
        data-plan-id="{{ $plan->id }}"
        data-csrf="{{ csrf_token() }}"
        data-process-url="{{ route('checkout.subscription') }}"
        data-subscription-id="{{ $subscription->id }}"
        data-public-key="{{ env('MP_PUBLIC_KEY') }}"
    ></div>
            <div id="form-checkout"></div>
            <div id="status-screen-container" style="display: none;"></div>
            <p></p>
        </div>
    </div>


    <input type="hidden" id="plan_price" value="{{ $plan->price }} ">
    <input type="hidden" id="plan_id" value="{{ $plan->id }} ">
</div>
