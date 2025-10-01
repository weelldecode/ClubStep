<div class="space-y-12 px-10 md:px-8  mt-42">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl ">
        <div class="grid auto-rows-min gap-4 md:grid-cols-2">
            <div class="relative aspect-2/1  overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-2/1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>

    </div>
    {{-- Seção Recomendadas --}}
    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold">Coleções Recomendadas</h2>
            <flux:button  variant="primary"  href="{{ route('collection.index') }}"  >
                Ver todas
            </flux:button >
        </div>

        <div class="flex gap-4 overflow-x-auto scrollbar-hide py-2">
            @foreach($recomendadas  as $index => $colecao)
                <div class="min-w-[350px] max-w-[350px] flex-shrink-0">
                    <x-card-collection :colecao="$colecao" :index="$index" />
                </div>
            @endforeach
        </div>
    </section>
    @auth
    {{-- Seção Dos que você segue --}}
    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold">Coleções de quem você segue</h2>
            <flux:button  href="{{ route('collection.index') }}"  variant="primary">
                Ver todas
            </flux:button >
        </div>

        <div class="flex gap-4 overflow-x-auto scrollbar-hide py-2">
            @forelse($dosSeguidos   as $index => $colecao)
                <div class="min-w-[350px] max-w-[350px] flex-shrink-0">
                  <x-card-collection :colecao="$colecao"    :index="$index" />
                </div>
            @empty
                <p class="text-gray-500">Ainda não há coleções novas dos artistas que você segue.</p>
            @endforelse
        </div>
    </section>
    @endauth
    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold">Autores em Destaque</h2>

        </div>

        <div class="flex gap-4 overflow-x-auto scrollbar-hide py-2">
            @foreach($featuredArtists as $user)
                <div class="min-w-[120px] flex-shrink-0 text-center hover:-translate-y-1  transition-all duration-500">
                    <a href="/profile/{{ $user->slug }}">
                    @php $avatar = $user->avatar(); @endphp
                    @if($avatar['type'] === 'image')
                        <img src="{{ $avatar['value'] }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover mx-auto">
                    @else
                        <div class="w-20 h-20 rounded-full bg-gray-300 flex items-center justify-center text-lg font-bold text-gray-700 mx-auto">
                            {{ $avatar['value'] }}
                        </div>
                    @endif
                    <p class="text-sm mt-2 font-bold text-zinc-700 dark:text-zinc-50 truncate">{{ $user->name }}</p></a>
                </div>
            @endforeach
        </div>
    </section>
    {{-- Categorias --}}
    @foreach($categorias as $categoria)
        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-3xl font-bold">{{ $categoria->name }}</h2>
                <flux:button  href="{{ route('collection.index') }}"   variant="primary">
                    Ver todas
                </flux:button >
            </div>

            <div class="flex gap-4 overflow-x-auto scrollbar-hide py-2">
                @foreach($categoria->collections  as $index => $colecao)
                    <div class="min-w-[350px] max-w-[350px] flex-shrink-0">
                      <x-card-collection :colecao="$colecao" :index="$index" />
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach

</div>
