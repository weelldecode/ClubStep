<div>
    {{-- Banner --}}
    <div id="bannerComponent"  class="relative top-0 w-full h-[20rem] -mt-6 shadow overflow-hidden">

        {{-- Banner atual --}}
        <img id="bannerDisplay"
             src="{{ $user->profile_banner ? asset('storage/' . $user->profile_banner) : 'https://mangadex.org/img/group-banner.png' }}"
             class="w-full h-full object-cover">

        @auth
            @if(auth()->id() === $user->id)

            {{-- Input de arquivo escondido --}}
            <input type="file" id="bannerInput" class="hidden" accept="image/*">

            {{-- Botão hover para selecionar --}}
            <button type="button"
                    onclick="document.getElementById('bannerInput').click()"
                    class="absolute top-6 right-0 px-4 py-2 bg-accent/20 w-full h-full font-bold text-white rounded-lg opacity-0 hover:opacity-100 transition cursor-pointer">
                Alterar Banner
            </button>

            {{-- Canvas para crop, inicial invisível --}}

            {{-- Canvas real para crop --}}
            <canvas id="bannerCanvas" width="1865" height="320"
                    class="absolute top-0 left-0 w-full h-full hidden cursor-grab"></canvas>

            {{-- Canvas overlay só para grade --}}
            <canvas id="gridOverlay" width="1865" height="320"
                    class="absolute top-0 left-0 w-full h-full pointer-events-none hidden"></canvas>
            <div class="flex items-center gap-5">

                {{-- Botão salvar crop --}}
                <button id="saveBannerBtn"
                        onclick="saveBannerCrop()"
                        class="absolute bottom-4 right-4 px-5 z-50 py-2 bg-accent hover:bg-accent-content font-bold text-white rounded-lg hidden">
                    Salvar Banner
                </button>
                {{-- Botão resetar posição --}}
                <button id="resetBannerBtn"
                        onclick="resetBannerCrop()"
                        class="absolute bottom-4 right-44 px-5 z-50 py-2 bg-zinc-600 hover:bg-zinc-900 font-bold text-white rounded-lg hidden">
                    Resetar
                </button>
            </div>
            @endif
        @endauth
    </div>

    <div class="mb-28">
        <div class="container mx-auto">

            <div class="grid grid-cols-6 grid-rows-1 gap-5">
                <div class="relative w-[210px]">
                    {{-- Badge de verificado --}}
                    @if ($user->type === 'verified')
                        <div class="absolute -top-8 right-5 bg-accent p-2 rounded-full text-white shadow-lg z-50">
                            <flux:icon name="crown" class="w-5 h-5"/>
                        </div>
                    @endif

                    {{-- Avatar --}}
                    <div class="relative -top-12 left-0 border-8 border-zinc-50 dark:border-zinc-800 rounded-full overflow-hidden">
                        <img src="{{ asset('storage/' . $user->profile_image) }}" class="w-full h-full rounded-full object-cover" alt="Avatar">

                        @auth
                            @if(auth()->id() === $user->id)
                                <!-- Overlay hover para alterar avatar -->
                                <label class="absolute inset-0 flex items-center justify-center bg-black/50 bg-opacity-40 text-white opacity-0 hover:opacity-100 cursor-pointer transition-opacity"
                                       title="Clique para alterar o avatar">
                                    <flux:icon name="image" class="w-6 h-6"/>
                                    <input type="file" wire:model="avatarTemp" class="absolute inset-0 opacity-0 cursor-pointer">
                                </label>
                            @endif
                        @endauth
                    </div>

                    {{-- Follow / Unfollow --}}
                    <div class="flex items-center flex-col -mt-8">
                        @auth
                            @if(auth()->id() !== $user->id)
                                <flux:button type="button" wire:click="toggleFollow" variant="danger" class="w-full flex items-center gap-5">
                                    {{ $isFollowing ? 'Deixar de seguir' : 'Seguir' }}
                                </flux:button>
                            @endif
                        @endauth
                    </div>
                </div>

                {{-- Conteúdo do Perfil --}}
                <div class="col-span-5 mt-5">
                    <div>
                        <h2 class="font-bold text-xl tracking-wide text-zinc-700 dark:text-zinc-50 flex items-center gap-2">
                              {{ $user->name }}

                              @if ($user->is_private)
                                  <span class="px-2 py-0.5 text-xs rounded-full bg-zinc-200 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-200 flex items-center gap-1">
                                      <flux:icon name="lock" class="w-3 h-3"/>
                                      Privado
                                  </span>
                              @endif
                          </h2>

                        {{-- Seguidores e Seguindo --}}
                        <div class="flex space-x-2 text-sm my-2">
                            @if(!$user->hide_followers)
                                <flux:badge size="sm">{{ $followersCount }} Seguidores</flux:badge>
                            @endif

                            @if(!$user->hide_following)
                                <flux:badge size="sm">{{ $followingCount }} Seguindo</flux:badge>
                            @endif
                        </div>

                        {{-- Biografia --}}
                        <p class="italic font-normal text-zinc-600 dark:text-zinc-200 mt-8 mb-5">
                            {{ $user->biography ?: 'Biografia não definida' }}
                        </p>
                    </div>

                    <flux:separator />
                    @if ($user->is_private && auth()->id() !== $user->id)
                        <div class="col-span-full flex flex-col items-center justify-center py-10 text-zinc-500 dark:text-zinc-100">
                            <flux:icon name="lock" class="w-10 h-10 mb-3"/>
                            <p class="text-lg font-semibold">Este perfil é privado</p>
                            <p class="text-sm">Siga o usuário para ver suas coleções e atividades.</p>
                        </div>

                    @elseif($user->hide_collections && auth()->id() !== $user->id)
                            <p class="text-zinc-400 italic mt-8 text-xl font-bold mx-auto flex items-center justify-center">As coleções deste usuário estão ocultas.</p>
                    @else
                    {{-- Coleções --}}
                    <h2 class="text-xl font-semibold mt-6 mb-8">Coleções</h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                            @forelse($collections as $index => $collection)
                                <div x-data="{ visible: false }"
                                     x-init="setTimeout(() => visible = true, {{ $index * 100 }})"
                                     :class="{ 'opacity-100 translate-y-0': visible, 'opacity-0 translate-y-4': !visible }"
                                     class="hover:-translate-y-2 overflow-hidden cursor-pointer transition-all duration-500 ease-out opacity-0 translate-y-4">
                                    <a href="/collection/v/{{ $collection->slug }}">
                                        @php
                                            $allImages = [];
                                            foreach ($collection->items as $item) {
                                                $itemImages = is_array($item->images) ? $item->images : json_decode($item->images, true);
                                                if($itemImages) { $allImages = array_merge($allImages, $itemImages); }
                                            }
                                            $imagesToShow = array_slice($allImages, 0, 4);
                                        @endphp

                                        @if(!empty($imagesToShow))
                                            <div class="grid grid-cols-2 gap-1">
                                                @foreach($imagesToShow as $img)
                                                    <img src="{{ asset('storage/' . $img) }}" alt="{{ $collection->name }}" class="w-full h-36 object-cover rounded-lg"/>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="grid grid-cols-2 gap-1">
                                                @for($i=0;$i<4;$i++)
                                                    <div class="w-full h-36 bg-zinc-200 flex items-center justify-center text-zinc-400 rounded-lg">
                                                        Sem imagem
                                                    </div>
                                                @endfor
                                            </div>
                                        @endif

                                        <div class="mt-3">
                                            <h3 class="text-base font-bold tracking-wide text-zinc-600 dark:text-zinc-50">
                                                {{ $collection->name }}
                                            </h3>
                                            <span class="font-semibold text-xs text-zinc-400 dark:text-zinc-100 tracking-wider">
                                                {{ count($collection->items) === 0 ? 'Nenhum arquivo' : count($collection->items) . ' ' . Str::plural('Arquivo', count($collection->items)) }}
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            @empty
                                <span class="col-span-full text-zinc-400 mx-auto italic tracking-wide">
                                    Nenhuma coleção postada.
                                </span>
                            @endforelse
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
