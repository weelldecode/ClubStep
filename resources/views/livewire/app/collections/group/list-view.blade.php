<ul class="divide-y divide-gray-300">
    @forelse($collections  as $index => $collection)
        <li x-data="{ visible: false }" x-init="setTimeout(() => visible = true, {{ $index * 100 }})"
            :class="{ 'opacity-100 translate-y-0': visible, 'opacity-0 translate-y-4': !visible }"
            class="hover:-translate-y-2 hover:shadow-md overflow-hidden cursor-pointer  transition-all duration-500 ease-out  bg-white dark:bg-zinc-900 rounded mb-5 p-4">
                <a href="/collection/v/{{ $collection->slug }}">

            <div class="flex items-center gap-5">

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
                $imagesToShow = array_slice($allImages, 0, 1);
            @endphp

            @if (!empty($imagesToShow))
                <div class="grid grid-cols-1 gap-1">
                    @foreach ($imagesToShow as $img)
                        <img src="{{ asset('storage/' . $img) }}" alt="{{ $collection->name }}"
                            class="w-full h-38 object-cover rounded-lg"/>
                    @endforeach
                </div>
            @else
                <div class="grid grid-cols-1 gap-1">
                        <div class="w-38  h-38 bg-zinc-200 flex items-center justify-center text-zinc-400 rounded-lg">
                            Sem imagem
                        </div>
                </div>
            @endif
                <div class="flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">{{ $collection->name }}</h3>
                    <p class="text-sm text-gray-600 dark:text-zinc-100 mb-5">{{ $collection->description }}</p>
                    </div>
            <div class="flex items-center gap-1">

                <div class=" font-semibold  text-xs text-zinc-400 dark:text-zinc-100  tracking-wider">
                    @php
                        $count = sizeof($collection->items);
                    @endphp

                    @if ($count === 0)
                        Nenhum arquivo
                    @else
                        {{ $count }} {{ Str::plural('Arquivo', $count) }} |
                    @endif
                </div>
            @if ($collection->categories->isNotEmpty())
                <div class=" flex flex-wrap gap-2">
                    @foreach ($collection->categories as $cat)
                        <span class="text-xs  text-accent font-semibold  ">
                            {{ $cat->name }}
                        </span>
                    @endforeach
                </div>
            @endif

            </div>
                </div>

            </div>
                </a>
        </li>
    @empty
    <div class="col-span-full flex flex-col items-center justify-center py-20 text-zinc-500 dark:text-zinc-100 ">
        <flux:icon name="layers-2" class="w-10 h-10 mb-3 text-accent dark:text-zinc-100"/>
        <p class="text-lg text-zinc-600 dark:text-zinc-50 font-semibold">Nenhuma coleção encontrada.</p>
        <p class="text-sm text-zinc-500 dark:text-zinc-200">O Filtro selecionado não possui coleções.</p>
    </div>
    @endforelse
</ul>
