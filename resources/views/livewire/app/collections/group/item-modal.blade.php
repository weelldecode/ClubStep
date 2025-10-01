<!-- Modal (substitui o anterior) -->
<template x-teleport="body">
    <div x-data="{ open: @entangle('showModal') }" x-show="open" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center"
        @keydown.escape.window="open = false">
        <!-- Fundo -->
        <div x-show="open" x-transition.opacity.duration.300ms class="absolute inset-0 bg-black/40 backdrop-blur-sm"
            @click="open = false"></div>

        <!-- Caixa do modal -->
        <div x-show="open" x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="scale-90 opacity-0" x-transition:enter-end="scale-100 opacity-100"
            x-transition:leave="transform transition ease-in duration-200"
            x-transition:leave-start="scale-100 opacity-100" x-transition:leave-end="scale-90 opacity-0"
            class="relative bg-white dark:bg-zinc-900 rounded-xl shadow-xl max-w-5xl w-[100vw] md:w-[60rem] p-6"
            role="dialog" aria-modal="true">
            <!-- Fechar -->
            <button
                class="absolute top-5 right-5 h-6 w-6 flex items-center justify-center bg-zinc-100 dark:bg-zinc-700 rounded-full text-zinc-600 dark:text-zinc-300 hover:text-red-600  hover:bg-zinc-200 dark:hover:bg-zinc-800  transition-all duration-300 cursor-pointer"
                @click="open = false" aria-label="Fechar modal">
                <flux:icon.x class="size-5" />
            </button>

            @if ($selectedItem)
                <div class="sm:block md:flex  gap-5">
                    <div class="">
                        @php
                            // junta todas as imagens dos itens da coleção em um array único
                            $allImages = [];
                            $itemImages = is_array($selectedItem->images)
                                ? $selectedItem->images
                                : json_decode($selectedItem->images, true);
                            if ($itemImages) {
                                $allImages = array_merge($allImages, $itemImages);
                            }

                            // pega só as primeiras 4 imagens do array completo
                            $imagesToShow = array_slice($allImages, 0, 4);
                        @endphp

                        @if (!empty($imagesToShow))
                            <div class="grid grid-cols-2 gap-1">
                                @foreach ($imagesToShow as $i => $img)
                                    <img src="{{ asset('storage/' . $img) }}" alt="{{ $collection->name }}"
                                        class=" sm:w-full md:w-[310px]  object-cover rounded-lg transition-all duration-700 opacity-100 " />
                                @endforeach
                            </div>
                        @else
                            <div class="grid grid-cols-2 gap-1">
                                @for ($i = 0; $i < 1; $i++)
                                    <div
                                        class=" sm:w-full md:w-[310px] bg-zinc-200 flex items-center justify-center gap-5 text-zinc-400 rounded-lg">
                                        Sem imagem
                                    </div>
                                @endfor
                            </div>
                        @endif

                    </div>
                    <div class="w-[35rem] flex flex-col justify-between gap-4">
                        <div class="">

                            <h2 class="text-2xl font-semibold mb-2">{{ $selectedItem->name }}</h2>
                            @if (!empty($selectedItem->description))
                                <p class="line-clamp-3 text-zinc-600 dark:text-zinc-300 mb-4 text-sm">
                                    {{ $selectedItem->description }}
                                </p>
                            @endif

                            <flux:separator />
                            <div class="flex items-center gap-4 mt-4">

                                <flux:button class="w-full" size="sm">
                                    Salvar
                                </flux:button>
                                <flux:button class="w-full" variant="primary" color="red" size="sm">
                                    Denunciar
                                </flux:button>
                            </div>
                        </div>
                        <div class="flex flex-col w-full gap-5">
                            <div class="  flex flex-col items-center gap-6">
                                <div class="flex flex-col gap-2 w-full border border-accent p-4 rounded bg-accent/5">

                                    <h1 class="text-base font-bold text-accent flex items-center gap-2"> Arquivo Premium
                                    </h1>
                                    <p class="text-justify  text-sm font-medium text-zinc-600 dark:text-zinc-100">
                                        Este arquivo está disponível exclusivamente apenas para membros Club, crie uma
                                        conta ou vire um Assinante Club para fazer o Download do pacote.
                                    </p>
                                </div>
                                @auth
                                    @if (!auth()->user()->activeSubscription())
                                     <div x-data="{ hovered: false }" class="relative w-full">
                                        <a @mouseenter="hovered = true" @mouseleave="hovered = false" href="/plans"
                                            class="relative group overflow-hidden border border-transparent bg-accent hover:bg-accent/80 text-white px-6 py-3 w-full rounded text-sm font-medium flex items-center justify-center gap-2 transition duration-300">


                                            <!-- Ícone -->
                                            <svg class="w-4 h-4 mr-2" fill="currentColor"
                                                viewBox="0 0 20 20"><!-- ícone aqui --></svg>

                                            <!-- Texto com animação -->
                                            <span x-show="!hovered" x-transition:enter="transition transform duration-300"
                                                x-transition:enter-start="opacity-0 translate-y-2"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition transform duration-300"
                                                x-transition:leave-start="opacity-100 translate-y-0"
                                                x-transition:leave-end="opacity-0 -translate-y-2" class="absolute">Download
                                                (25MB)
                                            </span>

                                            <span x-show="hovered" x-transition:enter="transition transform duration-300"
                                                x-transition:enter-start="opacity-0 translate-y-2"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition transform duration-300"
                                                x-transition:leave-start="opacity-100 translate-y-0"
                                                x-transition:leave-end="opacity-0 -translate-y-2" class="absolute">Assine o
                                                Premium </span>
                                        </a>
                                    </div>
                                    @else

                                        <flux:button  wire:click="startDownload({{ $selectedItem->id }})"
                                            class="w-full" variant="primary" icon:trailing="arrow-down-tray">
                                            Baixar Arquivo (46MB)
                                        </flux:button>
                                    @endif
                                @else
                                    <div x-data="{ hovered: false }" class="relative w-full">
                                        <a @mouseenter="hovered = true" @mouseleave="hovered = false" href="/plans"
                                            class="relative group overflow-hidden border border-transparent bg-accent hover:bg-accent/80 text-white px-6 py-3 w-full rounded text-sm font-medium flex items-center justify-center gap-2 transition duration-300">


                                            <!-- Ícone -->
                                            <svg class="w-4 h-4 mr-2" fill="currentColor"
                                                viewBox="0 0 20 20"><!-- ícone aqui --></svg>

                                            <!-- Texto com animação -->
                                            <span x-show="!hovered" x-transition:enter="transition transform duration-300"
                                                x-transition:enter-start="opacity-0 translate-y-2"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition transform duration-300"
                                                x-transition:leave-start="opacity-100 translate-y-0"
                                                x-transition:leave-end="opacity-0 -translate-y-2" class="absolute">Download
                                                (25MB)
                                            </span>

                                            <span x-show="hovered" x-transition:enter="transition transform duration-300"
                                                x-transition:enter-start="opacity-0 translate-y-2"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition transform duration-300"
                                                x-transition:leave-start="opacity-100 translate-y-0"
                                                x-transition:leave-end="opacity-0 -translate-y-2" class="absolute">Assine o
                                                Premium </span>
                                        </a>
                                    </div>
                                @endauth
                            </div>
                            <div
                                class="relative flex items-center gap-3 text-base font-medium text-zinc-700 dark:text-zinc-50">
                                @php
                                    $author = $collection->user;
                                @endphp


                        @if ($author)

                            <div class="mt-6 flex items-center gap-4">
                                {{-- Avatar --}}
                                @if ($author->profile_image)
                                    <flux:avatar size="lg"
                                        src="{{ asset('storage/' . $author->profile_image) }}" />
                                @else
                                    <div
                                        class="w-10 h-10 rounded-full bg-zinc-300 flex items-center justify-center text-sm font-bold text-white">
                                        {{ $author->initials() }}
                                    </div>
                                @endif
                                <div>
                                    <flux:heading size="lg">{{ $author->name }}</flux:heading>
                                    <flux:text>
                                        @if ($author->type === 'verified')
                                            <flux:text class="flex items-center gap-1">Verificado <flux:icon.badge-check
                                                    class="size-4" /></flux:text>
                                        @endif
                                    </flux:text>
                                </div>
                            </div>
                        @endif

                            </div>
                            <!-- Exemplo extra: baixar via rota (se quiser headers bonitinhos)
          -->
                        </div>
                    </div>
                </div>


            @endif
        </div>
    </div>
</template>
