<div class="mt-38 flex  px-10 gap-8  ">

<div class="realtive">
    <div
        class=" z-10   backdrop backdrop-blur-sm     h-full w-[22rem]    transition-shadow duration-700 ease-in-out">

        <h2 class="text-base tracking-wider mb-5 text-zinc-500 dark:text-zinc-50 font-bold flex items-center gap-3">
            <flux:icon.sliders-horizontal class="size-5" /> Filtros
        </h2>
        <flux:separator />

        <div class="flex flex-col gap-6 mt-5">

            <!-- Filtro por categorias de coleção -->
            <div x-data="{ openCat: true }" >
                <button
                    @click="openCat = !openCat"
                    class="flex items-center justify-between w-full   "
                >
                    <div class="flex  flex-col items-center  ">
                        <h2 class="text-base font-semibold text-zinc-600 dark:text-zinc-300">Tipo de Conteúdo</h2>
                        <span class="text-xs tracking-wider text-zinc-500 dark:text-zinc-200 font-medium  ">

                        </span>
                    </div>

                    <flux:icon.chevron-down
                        class="size-4 transform transition-transform duration-300"
                        x-bind:class="openCat ? 'rotate-180' : ''"
                    />
                </button>

                <div x-show="openCat" x-transition x-cloak class=" mt-3">
                    <flux:checkbox.group wire:model.live="selectedCollectionCategories">
                        @foreach ($allCategories as $category)
                            <flux:checkbox label="{{ $category->name }}" value="{{ $category->id }}" checked />
                        @endforeach
                    </flux:checkbox.group>
                </div>
            </div>
            <flux:separator />
            <!-- Filtro por categorias de coleção -->
            <div x-data="{ openTag: true }" >
                <button
                    @click="openTag = !openTag"
                    class="flex items-center justify-between w-full   "
                >
                    <div class="flex  flex-col items-center  ">
                        <h2 class="text-base font-bold text-zinc-600 dark:text-zinc-300">Formato</h2>
                        <span class="text-xs tracking-wider  text-zinc-500 dark:text-zinc-200 font-medium  ">

                        </span>
                    </div>

                    <flux:icon.chevron-down
                        class="size-4 transform transition-transform duration-300"
                        x-bind:class="openTag ? 'rotate-180' : ''"
                    />
                </button>

                <div x-show="openTag" x-transition x-cloak class=" mt-3">
                    <flux:checkbox.group wire:model.live="selectedCollectionTags">
                        @foreach ($allTags as $tag)
                            <flux:checkbox label="{{ $tag->name }}" value="{{ $tag->id }}" checked />
                        @endforeach
                    </flux:checkbox.group>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="flex flex-col gap-5 w-full  ">            <!-- Busca -->
    <div>
        <flux:input icon="magnifying-glass" placeholder="Buscar coleções..."
            wire:model.live.debounce.500ms="search" />
    </div>

        <div class="flex items-center gap-5 justify-between w-full">

            <!-- Botão para alternar modo de visualização -->
            <div x-data="{ viewMode: @entangle('viewMode') }" class="mb-4">
                <flux:button wire:click="toggleViewMode" variant="outline">
                    <span x-text="viewMode === 'card' ? 'Mudar para Lista' : 'Mudar para Card'"></span>
                </flux:button>
            </div>

            <!-- Ordenação -->
            <div class="flex items-center gap-4 w-[25rem]">
                <x-select  wire:model.live="sortField" placeholder="Select one status"
                    :options="[
                        ['name' => 'Nome', 'id' => 'name'],
                        ['name' => 'Data de criação', 'id' => 'created_at'],
                    ]" option-label="name" option-value="id"
                />


                <flux:button wire:click="toggleSortDirection" class="text-sm font-semibold text-zinc-600 dark:text-zinc-200 w-full" title="Alternar ordem"
                    aria-label="Alternar ordem">
                    @if ($sortDirection === 'asc')
                        Order Crescente
                    @else
                        Order Decrescente
                    @endif
                </flux:button>
            </div>
        </div>

        <!-- Lista de coleções com visualização dinâmica -->
        <div x-data="{ viewMode: @entangle('viewMode') }" wire:ignore.self class="relative">
               <template x-if="viewMode === 'card'">
            <div x-show="viewMode === 'card'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95" style="display: none;">
                @include('livewire.app.collections.group.card-view')
            </div>
            </template>

            <template x-if="viewMode === 'list'">
                <div  x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95">
                    @include('livewire.app.collections.group.list-view')
                </div>
            </template>
        </div>

        <!-- Paginação -->
        <div class="mt-6">
            {{ $collections->links() }}
        </div>
    </div>
</div>
