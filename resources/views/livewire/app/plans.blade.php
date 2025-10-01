<div>
    <div class="max-w-6xl mx-auto p-6 mt-42 ">
        <div class="">
            <h1
                class="mx-auto text-5xl w-8/12 font-syne text-zinc-800 dark:text-white font-bold mb-3 text-center  animate__animated animate__fadeInDown">
                Atributos
                <span class="text-primary"> criativos</span>
                ilimitados, tudo
                em um só lugar.
            </h1>
            <p
                class="w-7/12 mb-12 font-medium text-base text-center text-zinc-600 dark:text-zinc-100  mx-auto  animate__animated animate__fadeInUp">
                Faça download de itens e
                modelos de qualidade incomparáveis de artistas globais, com
                uma
                assinatura com uma ótima relação custo-benefício.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-6 z-20">
            @forelse ($plans as $plan)
                <div
                    class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-6 animate__animated animate__fadeInUp bg-white dark:bg-zinc-900 ">
                    <h2 class="text-2xl font-semibold text-accent">{{ $plan->name }}</h2>
                    <p class="text-3xl font-extrabold mb-5 text-zinc-700 dark:text-white">R$ {{ $plan->price }}</p>
                    <p class="text-gray-700 mb-7 text-sm dark:text-zinc-100">{{ $plan->description }}</p>

                    <ul v-if="plan.features" class="flex flex-col gap-2 list-disc list-inside text-sm mb-7">

                        @foreach ($plan->features as $feature)
                            <li class="font-semibold text-zinc-700 dark:text-zinc-50">
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                    <div class="flex flex-col gap-3">
                        <flux:button variant="primary" href="{{ route('checkout.index', $plan->id) }}">Assinar
                        </flux:button>
                    </div>
                </div>
            @empty
                <p>Nenhum plano encontrado</p>
            @endforelse
        </div>
        <flux:separator class=" mt-16" />
        <div class="mt-16">
            <h2 class="text-4xl font-bold text-accent mb-10"">O que você terá acesso:</h2>
            <div class="grid md:grid-cols-2 gap-6 z-20  h-full ">
                <article class="bg-white dark:bg-zinc-900 p-6 rounded-lg   border border-zinc-200 dark:border-zinc-600">
                    <h4 class="text-2xl font-bold tracking-wide  mb-5">100.000+ Arquivos Editáveis</h4>
                    <flux:separator class=" mb-5" />
                    <ul class="flex flex-col gap-7">
                        <li class="flex items-center gap-4">
                            <div class="p-2  bg-green-600/20 dark:bg-green-600/20  rounded-xl">
                                <flux:icon.bolt variant="solid" class="text-green-500 dark:text-green-300" />
                            </div>
                            <div class="">
                                <h3 class="font-semibold text-base text-zinc-700 dark:text-zinc-50">Mais de 100.000
                                    arquivos editáveis</h3>
                                <span class="font-semibold text-sm text-zinc-700 dark:text-zinc-100">PSDs, elementos,
                                    imagens e mockups</span>
                            </div>
                        </li>
                        <li class="flex items-center gap-4">
                            <div class="p-2  bg-green-600/20 dark:bg-green-600/20  rounded-xl">
                                <flux:icon.bolt variant="solid" class="text-green-500 dark:text-green-300" />
                            </div>
                            <div class="">
                                <h3 class="font-semibold text-base text-zinc-700 dark:text-zinc-50">Mais de 100.000
                                    arquivos editáveis</h3>
                                <span class="font-semibold text-sm text-zinc-700 dark:text-zinc-100">PSDs, elementos,
                                    imagens e mockups</span>
                            </div>
                        </li>
                        <li class="flex items-center gap-4">
                            <div class="p-2  bg-green-600/20 dark:bg-green-600/20  rounded-xl">
                                <flux:icon.bolt variant="solid" class="text-green-500 dark:text-green-300" />
                            </div>
                            <div class="">
                                <h3 class="font-semibold text-base text-zinc-700 dark:text-zinc-50">Mais de 100.000
                                    arquivos editáveis</h3>
                                <span class="font-semibold text-sm text-zinc-700 dark:text-zinc-100">PSDs, elementos,
                                    imagens e mockups</span>
                            </div>
                        </li>

                    </ul>
                </article>

                <article class=" overflow-hidden">

                    <video class="w-full h-full object-cover rounded-lg" autoplay="" loop="" playsinline=""
                        preload="auto">
                        <source src="https://app.baixardesign.com.br/arquivos-editaveis.mp4" type="video/mp4">Seu
                        navegador não suporta vídeos HTML5.
                    </video>
                </article>
            </div>
        </div>
        <flux:separator class=" mt-16" />
        <div class="mt-16">
            <h1
                class="mx-auto text-5xl w-8/12 font-syne text-zinc-800 dark:text-white font-bold mb-3 text-center  animate__animated animate__fadeInDown">
                Ainda possui alguma dúvida?
            </h1>
            <p
                class="w-7/12 mb-7 font-medium text-base text-center text-zinc-600 dark:text-zinc-100  mx-auto  animate__animated animate__fadeInUp">
                Entre em contato pelo nosso email ou chat direto para solucionar todas suas dúvidas!</p>
            <div class="mx-auto flex items-center gap-5 justify-center">

                <flux:button variant="primary" color="green"  icon="phone">WhatsApp</flux:button>
                <flux:button variant="primary" color="blue"  icon="mail">E-mail</flux:button>
            </div>
        </div>
    </div>
</div>
