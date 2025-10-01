
<div >

    <div class="container mx-auto rounded-lg mt-42 bg-zinc-100 dark:bg-zinc-900/50 p-6 mb-10 border dark:border-zinc-700 border-zinc-200">
    <div class=" ">
        <livewire:components.breadcrumb />
        <h1 class="text-xl font-bold tracking-wider">Meus Downloads</h1>
        <p class="text-sm  dark:text-zinc-200">Veja todos downloads que você fez das coleções.</p>
    </div>
    </div>
    <section  class="container mx-auto ">

    <div class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        @forelse($downloads as $index =>  $download)
            <div  x-data="{ visible: false }" x-init="setTimeout(() => visible = true, {{ $index * 100 }})"
                :class="{ 'opacity-100 translate-y-0': visible, 'opacity-0 translate-y-4': !visible }" class="p-4 border dark:border-zinc-700 border-zinc-200 dark:bg-zinc-900/60 bg-zinc-100 rounded-lg flex flex-col justify-between gap-5 hover:-translate-y-2 overflow-hidden cursor-pointer transition-all duration-500 ease-out  opacity-0   translate-y-4">

                    <a href="/collection/v/{{ $download->collection->slug }}"  >
                @if (!empty($download->collection->image_path))
                    <div class="grid grid-cols-1 gap-1">
                            <img src="{{ asset('storage/' . $download->collection->image_path) }}" alt="{{ $download->collection->name }}"
                                class="w-full h-64 object-cover rounded-lg"/>

                    </div>
                @else
                    <div class="grid grid-cols-1 gap-1">
                            <div class="w-28  h-28 bg-zinc-200 flex items-center justify-center text-zinc-400 rounded-lg">
                                Sem imagem
                            </div>
                    </div>
                @endif
                <div class="flex flex-col justify-between gap-2 mt-5">
                    <p class="font-semibold text-base ">{{ $download->collection->name }}</p>
                    <p class="text-sm text-gray-500">Status: {{ __( ucfirst($download->status) )}}</p>
                </div>

                @if($download->status === 'ready' && $download->file_path)
                    <flux:button href="{{ Storage::url($download->file_path) }}"
                        variant="primary">
                        Baixar Item
                       </flux:button >
                @else
                    <span class="text-gray-400 italic">Processando...</span>
                @endif
                    </a>
            </div>
        @empty
        <div class="col-span-full flex flex-col items-center justify-center py-20 text-zinc-500 dark:text-zinc-100 ">
            <flux:icon name="download" class="w-10 h-10 mb-3 text-accent dark:text-zinc-100"/>
            <p class="text-lg text-zinc-600 dark:text-zinc-50 font-semibold">Você não baixou nada ainda.</p>
            <p class="text-sm text-zinc-500 dark:text-zinc-200">Navegue no nosso site para obter downloads ilimitados.</p>
        </div>

        @endforelse
        </div>
    </div>
    </section>
</div>
