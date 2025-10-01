<div x-data="{ open: @json($showSubscriptionModal) }" x-show="open" x-transition
    class="fixed inset-0 bg-black/15 bg-opacity-30 flex items-center justify-center z-50" style="display: none;">
    <div @click.away="open = false"
        class="bg-white dark:bg-zinc-900 rounded-lg shadow-lg max-w-xl w-full p-6 mx-4 text-center relative">
        <button @click="open = false" wire:click="closeModal" aria-label="Fechar modal"
            class="absolute top-3 right-3 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition">
            <flux:icon.x />
        </button>

        <div class="text-3xl font-bold mb-0 tracking-wider text-accent">Assinatura Ativa</div>

        <h2 class="text-base font-semibold text-zinc-900 dark:text-zinc-100 mb-5">
            Obrigado por assinar!
        </h2>

        <p class="text-gray-700 dark:text-gray-300 mb-6">
            Sua assinatura está ativa! Prepare-se para aproveitar ao máximo os benefícios do ClubStep e dar o próximo
            passo com a gente.
        </p>

        <flux:button @click="open = false;" wire:click="closeModal" variant="primary" class="w-full">
            Fechar
        </flux:button>
    </div>
</div>
