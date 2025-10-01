<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
    @forelse($collections as $index => $collection)
        <div x-data="{ visible: false }" x-init="setTimeout(() => visible = true, {{ $index * 100 }})"
            :class="{ 'opacity-100 translate-y-0': visible, 'opacity-0 translate-y-4': !visible }"
            class="hover:-translate-y-2 overflow-hidden cursor-pointer transition-all duration-500 ease-out opacity-0 translate-y-4">
            <a href="/collection/v/{{ $collection->slug }}">
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

            @if (!empty($imagesToShow))
                <div class="grid grid-cols-2 gap-1">
                    @foreach ($imagesToShow as $img)
                        <img src="{{ asset('storage/' . $img) }}" alt="{{ $collection->name }}"
                            class="w-full h-42 object-cover rounded"/>
                    @endforeach
                </div>
            @else
                <div class="grid grid-cols-2 gap-1">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="w-full h-42 bg-zinc-200 flex items-center justify-center text-zinc-400 rounded  ">
                            Sem imagem
                        </div>
                    @endfor
                </div>
            @endif

            <div class="mt-3">

                <h3 class="text-base font-bold   tracking-wide text-zinc-600 dark:text-zinc-50">
                    {{ $collection->name }}</h3>
                <div class="flex items-center gap-1 mt-2">

                        <div class=" font-medium  text-xs text-zinc-400 dark:text-zinc-100  tracking-wider">
                            @php
                                $count = sizeof($collection->items);
                            @endphp

                            @if ($count === 0)
                                Nenhum arquivo
                            @else
                                {{ $count }} {{ Str::plural('Arquivo', $count) }} |
                            @endif
                        </div>
                        @foreach ($collection->categories as $cat)
                            <div
                                class=" text-accent text-xs font-semibold tracking-wide">{{ $cat->name }}</div>
                        @endforeach
                </div>

            </div>
            </a>
        </div>

    @empty
    <div class="col-span-full flex flex-col items-center justify-center py-20 text-zinc-500 dark:text-zinc-100 ">
        <flux:icon name="layers-2" class="w-10 h-10 mb-3 text-accent dark:text-zinc-100"/>
        <p class="text-lg text-zinc-600 dark:text-zinc-50 font-semibold">Nenhuma coleção encontrada.</p>
        <p class="text-sm text-zinc-500 dark:text-zinc-200">O Filtro selecionado não possui coleções.</p>
    </div>
    @endforelse
</div>
