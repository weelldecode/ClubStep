<section class="w-full container mx-auto mt-42">
    <flux:heading size="xl" level="1">{{ __('Billing and Invoicing') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('View your plan information or switch plans according to your needs.') }}</flux:subheading>
    <flux:separator variant="subtle" />

    <div class="flex items-start max-md:flex-col">

        <flux:separator class="md:hidden" />

        <div class="flex-1 self-stretch max-md:pt-6">

            <div class="mt-5 w-full  bg-zinc-100 dark:bg-zinc-950 rounded p-6">

                <div class="grid grid-cols-2 grid-rows-1 gap-10 mb-5 ">
                    <div class=" rounded-md">
                        <h2 class="text-3xl font-bold text-accent mb-2">
                              {{ $subscription?->plan?->name ?? 'Sem plano' }}
                          </h2>
                          <div class="mb-2">
                              <div class="flex items-center justify-between">
                                  <p class="dark:text-zinc-300 text-zinc-700 text-sm font-medium dark:text-zinc-50">Downloads</p>

                                  <p class="dark:text-zinc-300 text-zinc-700 text-sm font-medium dark:text-zinc-50 text-sm mt-1">
                                      {{ $downloadsHoje }} de {{ $limiteDiario }} diários
                                  </p>
                              </div>
                                 <div class="relative w-full h-6 bg-zinc-200 dark:bg-zinc-600 rounded mt-1">
                                     <div
                                         class="h-6 bg-emerald-500 rounded-md"
                                         style="width: {{ $percentualDownloads }}%;">
                                     </div>
                                 </div>

                             </div>
                    </div>
                    <div class=" ">
                        <h2 class="text-2xl font-bold text-zinc-700 dark:text-white ">
                           Minha Assinatura
                          </h2>
                          <div class="mb-2 text-zinc-500 font-semibold dark:text-zinc-50 text-base ">
                              Status: {{ __(ucfirst($subscription->status ?? 'indefinido')) }}
                    </div>

                          <div class="text-zinc-600 dark:text-zinc-100 text-sm">
                               Início: {{ $inicio ?? '-' }}
                          </div>
                           <div class="text-zinc-600 dark:text-zinc-100 text-sm">
                               Vencimento: {{ $vencimento ?? '-' }}
                           </div>

                    </div>

                </div>
                <flux:separator/>
                <div class=" mt-5">
                    <h3 class="text-zinc-700 dark:text-white text-lg  font-bold ">Faturas recentes</h3>
                    <div class="text-zinc-700 dark:text-zinc-100 text-sm  mb-5">Veja suas faturas criadas recentemente.</div>
                    <ul class="divide-y divide-zinc-600">
                           @forelse($faturas as $fatura)
                               <li class=" flex justify-between items-center text-sm text-zinc-300 border border-zinc-200 dark:border-transparent dark:text-zinc-50 bg-zinc-50 dark:bg-zinc-700 p-4 rounded-md">
                                   <div class="flex flex-col">

                                       <span class="text-zinc-700 dark:text-zinc-50 font-bold text-lg">
                                                             Plano: {{ $fatura->subscription?->plan?->name ?? '-' }}
                                                         </span>
                                       <span class="font-medium text-base text-zinc-600 dark:text-zinc-100">
                                           R$ {{ number_format($fatura->amount, 2, ',', '.') }}
                                       </span>
                                       <span class="text-xs text-zinc-400 dark:text-zinc-100">
                                           {{ $fatura->paid_at?->format('d/m/Y') ?? $fatura->created_at->format('d/m/Y') }}
                                       </span>
                                   </div>
                                   <div class="flex flex-col gap-2">
                                       <span class=" py-2 px-4 rounded font-bold
                                           @if($fatura->status === 'paid') text-green-400
                                           @elseif($fatura->status === 'pending') text-yellow-400
                                           @else text-red-100 bg-red-500 @endif
                                       ">
                                           {{ __(ucfirst($fatura->status)) }}
                                       </span>
                                   </div>

                               </li>
                           @empty

                           <div class="col-span-full flex flex-col items-center justify-center py-20 text-zinc-500 dark:text-zinc-100 ">
                               <flux:icon name="gallery-vertical-end" class="w-10 h-10 mb-3 text-accent dark:text-zinc-100"/>
                               <p class="text-lg text-zinc-600 dark:text-zinc-50 font-semibold">Nenhuma Fatura Gerada.</p>
                               <p class="text-sm text-zinc-500 dark:text-zinc-200">Você ainda não tem nenhuma fatura disponível.</p>
                           </div>
                           @endforelse
                       </ul>

                </div>
            </div>
        </div>
    </div>


</section>
