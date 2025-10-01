<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:header class="absolute top-0   bg-gradient-to-t from-transparent to-zinc-100 dark:to-zinc-950 flex flex-col items-start  w-full  h-32">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <div class=" w-full  ">
            <div class="h-16  px-10 flex items-center justify-between w-full  gap-10">

                <div class="w-full flex items-center justify-between">
                    <a href="{{ route('home') }}"
                    class="text-accent m-auto w-56  flex items-center  rtl:space-x-reverse   "
                    wire:navigate>
                    <img src="/assets/img/logo_club.webp" class=" w-full h-full" alt="">
                </a>
                 <div class="w-full ml-16">
                     <livewire:components.search-collections/>
                 </div>

                <div class="  ">
                    <div class="flex items-center gap-2">
                        <flux:navbar class="  me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">
                            @if(!auth()->user())
                            <flux:button href="{{ route('plans') }}" variant="primary">
                                Obtenha Downloads Ilimitados
                            </flux:button>
                            @endif
                        </flux:navbar>
                        @auth
                        <livewire:components.notifications-dropdown/>
                            <!-- Desktop User Menu -->
                            <flux:dropdown position="top" align="end">
                                @php
                                    $avatar = auth()->user()->avatar();
                                @endphp

                                @if ($avatar['type'] === 'image')
                                    <flux:profile avatar="{{ $avatar['value'] }}" name="{{ auth()->user()->name }}" />
                                @else
                                    <flux:profile class="cursor-pointer" :initials="$avatar['value']" />
                                @endif


                                <flux:menu>
                                    <flux:menu.group :heading="__('Account')">
                                        <flux:menu.item :href="route('profile.user', auth()->user()->slug)">Minha Conta</flux:menu.item>
                                        <flux:menu.item :href="route('settings.profile')">Configurações</flux:menu.item>
                                        <flux:menu.item :href="route('download')">Downloads</flux:menu.item>
                                    </flux:menu.group>
                                    <flux:menu.group   :heading="__('Billing')">
                                        <flux:menu.item :href="route('billing')">Assinatura</flux:menu.item>
                                    </flux:menu.group>
                                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                                        @csrf
                                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                                            class="w-full">
                                            {{ __('Log Out') }}
                                        </flux:menu.item>
                                    </form>
                                </flux:menu>

                            </flux:dropdown>
                        @else
                            <a href="{{ route('login') }}"
                                class="w-[10rem] rounded-md font-semibold text-base flex flex-col text-zinc-700 dark:text-zinc-50 hover:bg-zinc-100 dark:hover:bg-zinc-800 px-4 py-1  ">
                                Olá, Conecte-se
                                <span class="font-semibold text-xs text-zinc-500 dark:text-zinc-300 -mt-1">Contas e
                                    Coleções</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            </div>
        </div>
        <nav class="relative w-full px-10 bg-transparent border-t border-zinc-200 dark:border-zinc-700/20">
            <div class="flex items-center justify-between w-full">
                <flux:navbar class="  max-lg:hidden w-full ">
                    <flux:navbar.item :href="route('home')"
                        :current="request()->routeIs('home')" wire:navigate>
                        {{ __('Home') }}
                    </flux:navbar.item>
                    <flux:navbar.item :href="route('collection.index')"
                        :current="request()->routeIs('collection.index')" wire:navigate>
                        {{ __('Collections') }}
                    </flux:navbar.item>
                    @foreach ($globalCategories as $tag)
                        <flux:navbar.item href="{{ route('collection.index', $tag->slug) }}"
                            :current="request()->routeIs('collection.index') && request()->route('slug') === $tag->slug"
                            wire:navigate>
                            {{ $tag->name }}
                        </flux:navbar.item>
                    @endforeach

                </flux:navbar>
                @auth
                    @if(!auth()->user()->activeSubscription)
                        <flux:button href="{{ route('plans') }}" variant="primary">
                            Obtenha Downloads Ilimitados
                        </flux:button>
                    @endif
                @endauth
            </div>
        </nav>
    </flux:header>

    <!-- Mobile Menu -->
    <flux:sidebar stashable sticky
        class="lg:hidden border-e border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('home') }}" class="  w-62 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')">
                <flux:navlist.item icon="layout-grid" :href="route('home')"
                    :current="request()->routeIs('home')" wire:navigate>
                    {{ __('home') }}
                </flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit"
                target="_blank">
                {{ __('Repository') }}
            </flux:navlist.item>

            <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire"
                target="_blank">
                {{ __('Documentation') }}
            </flux:navlist.item>
        </flux:navlist>
    </flux:sidebar>
    <div
        x-data="{ scroll: 0, time: 0, isDark: document.documentElement.classList.contains('dark') }"
        x-init="
            window.addEventListener('scroll', () => scroll = window.scrollY);
            setInterval(() => { time += 1 }, 60);
            // observar mudanças de tema
            new MutationObserver(() => { isDark = document.documentElement.classList.contains('dark') })
                .observe(document.documentElement, { attributes: true });
        "
        class="relative min-h-screen"
    >
        <!-- Background dinâmico -->
        <div
            class="fixed inset-0 -z-10 transition-all duration-500 ease-out hidden"
            :style="`
                background: radial-gradient(
                    circle at
                        ${50 + Math.sin(time/20) * 20 + (scroll/40) % 100}%
                        ${50 + Math.cos(time/25) * 20 + (scroll/60) % 100}%,
                    ${isDark ? 'rgba(141,33,200,0.090)' : 'rgba(46,11,66,0.05)'},
                    ${isDark ? 'rgba(46,11,66,0.025)' : 'rgba(46,11,66,0.015)'},
                    ${isDark ? 'rgba(25,23,36,1)' : 'rgba(255,255,255,1)'}
                )
            `"
        ></div>
            {{ $slot }}

    <!-- Section 3 -->
    <footer class="w-full bg-zinc-100 dark:bg-zinc-950 mt-30 z-50 relative">
        <div class="  pt-14 pb-5 mx-auto container">
            <div class="grid grid-cols-2 gap-10 mb-3 md:grid-cols-3 lg:grid-cols-12 lg:gap-20">
                <div class="col-span-3">
                    <a href="{{ route('home') }}"
                        class="h-2 text-accent   w-42 flex items-center space-x-2 rtl:space-x-reverse mr-8"
                        wire:navigate>
                            <img src="/assets/img/logo_club.webp" alt="">
                    </a>
                    <p class="mt-8 text-sm">Coleções profissionais em segundos e assinatura que cabe no seu bolso.</p>
                </div>
                <nav class="col-span-1 md:col-span-1 lg:col-span-2">
                    <p class="mb-3 text-xs font-semibold tracking-wider text-zinc-400 dark:text-zinc-100 uppercase">Items</p>
                    <a href="#" class="flex mb-3 text-sm font-medium text-zinc-500 dark:text-zinc-50 transition hover:text-zinc-700 dark:hover:text-zinc-100 md:mb-2 hover:text-primary">Inicio</a>
                    <a href="#" class="flex mb-3 text-sm font-medium text-zinc-500 dark:text-zinc-50 transition hover:text-zinc-700 dark:hover:text-zinc-100 md:mb-2 hover:text-primary">Coleções</a>
                </nav>


                <nav class="col-span-2 md:col-span-1 lg:col-span-2">
                    <p class="mb-3 text-xs font-semibold tracking-wider text-zinc-400 dark:text-zinc-100  uppercase">Descubra</p>
                    <a href="#" class="flex mb-3 text-sm font-medium text-zinc-500 dark:text-zinc-50 transition hover:text-zinc-700 dark:hover:text-zinc-100  md:mb-2 hover:text-primary">Instagram</a>
                    <a href="#" class="flex mb-3 text-sm font-medium text-zinc-500 dark:text-zinc-50 transition hover:text-zinc-700 dark:hover:text-zinc-100 md:mb-2 hover:text-primary">Whatsapp</a>
                </nav>
                <nav class="col-span-2 md:col-span-1 lg:col-span-2">
                    <p class="mb-3 text-xs font-semibold tracking-wider text-zinc-400 dark:text-zinc-100  uppercase">   Termos Legais</p>
                    <a href="#" class="flex mb-3 text-sm font-medium text-zinc-500 dark:text-zinc-50 transition hover:text-zinc-700 dark:hover:text-zinc-100  md:mb-2 hover:text-primary">Instagram</a>
                    <a href="#" class="flex mb-3 text-sm font-medium text-zinc-500 dark:text-zinc-50 transition hover:text-zinc-700 dark:hover:text-zinc-100 md:mb-2 hover:text-primary">Whatsapp</a>
                </nav>
                <nav class="col-span-2 md:col-span-1 lg:col-span-2">
                    <p class="mb-3 text-xs font-semibold tracking-wider text-zinc-400 dark:text-zinc-100  uppercase">Contato</p>
                    <a href="#" class="flex mb-3 text-sm font-medium text-zinc-500 dark:text-zinc-50 transition hover:text-zinc-700 dark:hover:text-zinc-100  md:mb-2 hover:text-primary">Instagram</a>
                    <a href="#" class="flex mb-3 text-sm font-medium text-zinc-500 dark:text-zinc-50 transition hover:text-zinc-700 dark:hover:text-zinc-100 md:mb-2 hover:text-primary">Whatsapp</a>
                </nav>
                <div class="col-span-5 hidden">
                    <p class="mb-3 text-xs font-semibold tracking-wider text-zinc-400 dark:text-zinc-100  uppercase">Entre em contato</p>
                    <form action="#" class="mb-2">
                        <div class="relative flex items-center overflow-hidden border border-zinc-200 dark:border-zinc-700  rounded-lg">
                            <input class="w-full px-3 py-2 text-base leading-normal transition duration-150 ease-in-out bg-white dark:bg-zinc-800  appearance-none focus:outline-none" type="email" placeholder="Digite seu email">
                            <button class="px-3 py-2 text-xs   font-medium text-center text-white no-underline bg-indigo-500 border-2 border-indigo-500" type="submit">Enviar</button>
                        </div>
                    </form>
                    <p class="text-xs leading-normal text-zinc-500 dark:text-zinc-200">Mande um e-mail caso tenha alguma dúvida ou sugestão.</p>
                </div>
            </div>
            <div class="flex flex-col items-start justify-between pt-5 mt-5  border-t border-zinc-100 dark:border-zinc-700 md:flex-row md:items-center">
                <p class=" text-sm text-left text-zinc-600 dark:text-zinc-50 md:mb-0">© 2025 ClubStep. Todos direitos reservados.</p>

            </div>
        </div>
    </footer>
    <livewire:components.subscription-modal />
        <wireui:scripts />
    @fluxScripts
    <x-toast />
</body>

</html>
