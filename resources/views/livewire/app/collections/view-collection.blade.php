<div class=" relative">
    @php
        // junta todas as imagens dos itens da coleção em um array único
        $allImages = [];
        foreach ($collection->items as $item) {
            $itemImages = is_array($item->images) ? $item->images : json_decode($item->images, true);
            if ($itemImages) {
                $allImages = array_merge($allImages, $itemImages);
            }
        }

        // pega só as primeiras 4 imagens do array completo
        $imagesToShow = array_slice($allImages, 0, 4);
    @endphp


    <div class="container mx-auto ">
        <div class="flex gap-6 mt-42 z-50 ">
        <div class="w-[40rem] flex flex-col gap-5  border-r pr-6 border-zinc-200 dark:border-zinc-700 h-full">
            @if (!empty($imagesToShow))
                <div class="grid grid-cols-2 gap-2">
                    @foreach ($imagesToShow as $i => $img)
                        <img src="{{ asset('storage/' . $img) }}" alt="{{ $collection->name }}"
                            class="w-full h-48 object-cover rounded transition-all duration-700 opacity-100 " />
                    @endforeach
                </div>
            @else
                <div class="grid grid-cols-2 gap-1">
                    @for ($i = 0; $i < 4; $i++)
                        <div
                            class="w-full h-40 bg-zinc-200 flex items-center justify-center text-zinc-400 dark:text-zinc-600 rounded">
                            Sem imagem
                        </div>
                    @endfor
                </div>
            @endif
            <flux:separator />
            <div
                class="overflow-hidden dark:bg-zinc-950 bg-zinc-50 border border-zinc-200 dark:border-transparent p-4 rounded dark:shadow">

                <h1 class=" flex flex-col gap-1 text-xl font-bold tracking-wide dark:text-white text-zinc-800">
                    {{ $collection->name }}
                </h1>
                <p class="text-sm font-medium mt-2 text-zinc-500 dark:text-zinc-100">{{ $collection->description }}</p>
                <div class=" inline-flex flex-col gap-1 mt-5 w-full">
                    <div class="ftext-base font-medium text-zinc-700 dark:text-zinc-50 hidden">

                        @php
                            $count = sizeof($collection->items);
                        @endphp

                        @if ($count === 0)
                            Nenhum arquivo
                        @else
                            <span class=" font-semibold text-base text-zinc-500 dark:text-zinc-100 racking-wider">

                                {{ $count }} {{ Str::plural('Arquivo', $count) }} </span>
                        @endif
                    </div>
                    <div
                        class="mb-2 relative flex items-center gap-3 text-base font-medium text-zinc-700 dark:text-zinc-50">
                        @php
                            $author = $collection->user;
                        @endphp

                        @if ($author)
                            <div class="mt-2 flex items-center gap-4">
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
                    <flux:separator />
                    <ul class="flex flex-wrap gap-2  mt-2  ">
                        @foreach ($collection->tags as $tag)
                            <li class="bg-accent/15 border border-accent text-accent px-2 py-1  rounded text-xs font-semibold tracking-wide">{{ $tag->name }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
        <div wire:ignore.self class="relative w-full">
            <div class="flex items-center gap-5 justify-between w-full mb-10">

                <div class="w-[15rem]">
                    <x-select  wire:model.live="sortField" placeholder="Select one status"
                        :options="[
                            ['name' => 'Nome', 'id' => 'name'],
                            ['name' => 'Data de criação', 'id' => 'created_at'],
                        ]" option-label="name" option-value="id"
                    />

                </div>
                <!-- Ordenação -->
                <div class="flex items-center gap-4 ">


                    <flux:button wire:click="toggleSortDirection"
                    variant="outline"
                        class="text-sm font-semibold text-zinc-600 dark:text-zinc-200 w-full" title="Alternar ordem"
                        aria-label="Alternar ordem">
                        @if ($sortDirection === 'asc')
                            Order Crescente
                        @else
                            Order Decrescente
                        @endif
                    </flux:button>
                </div>
            </div>
            <div x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95">

                @if ($isItemView)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 ">
                        @forelse($items as $index => $item)
                            <div x-data="{ visible: false }" x-init="setTimeout(() => visible = true, {{ $index * 100 }})"
                                :class="{ 'opacity-100 translate-y-0': visible, 'opacity-0 translate-y-4': !visible }"
                                @click="$wire.showItem({{ $item->id }})"
                                class="group relative bg-zinc-900 hover:-translate-y-2 overflow-hidden cursor-pointer transition-all duration-500 ease-out opacity-0 translate-y-4 rounded  h-[280px] w-full ">

                                <img class='absolute inset-0 h-full w-full object-cover opacity-90 transition-opacity duration-300 ease-out group-hover:opacity-100 group-hover:transition-opacity group-hover:duration-300'
                                    src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">


                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-zinc-800/0 to-transparent to-110% text-white   group-hover:bg-gradient-to-t group-hover:from-black/90 dark:group-hover:from-zinc-950  hover:shadow-lg group-hover:transition-all group-hover:duration-300 transition-all duration-300">

                                    <h3
                                        class="  text-sm font-semibold tracking-wide absolute bottom-5 left-5 text-white  transform translate-y-2 opacity-0 transition-all duration-300 ease-out group-hover:translate-y-0 group-hover:opacity-100">
                                        {{ $item->name }}
                                    </h3>

                                    <div class="flex flex-col">

                                    </div>
                                </div>
                            </div>
                        @empty
                            <span class="col-span-full text-zinc-400 mx-auto italic tracking-wide">
                                Nenhum item encontrado.
                            </span>
                        @endforelse
                    </div>
                @endif
            </div>
        </div>
        </div>
        <section class="mt-14">
            <flux:separator />
                <div class="mt-14">
                    <h2 class="text-2xl font-bold mb-4">Coleções Relacionadas</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @forelse($relatedCollections as $rel)
                            <div class="border rounded p-3 shadow-sm hover:shadow-md transition">
                                <a href="{{ route('collections.show', $rel->slug) }}">
                                    <h3 class="font-semibold">{{ $rel->name }}</h3>
                                    <p class="text-sm text-gray-600">
                                        {{ Str::limit($rel->description, 60) }}
                                    </p>
                                </a>
                            </div>
                            @empty
                                <span class="col-span-full text-zinc-400 mx-auto italic tracking-wide">
                                    Nenhum item encontrado.
                                </span>
                            @endforelse
                    </div>
                </div>
        </section>
    </div>
    @include('livewire.app.collections.group.item-modal')
</div>
