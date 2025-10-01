<div class="relative">
    <flux:dropdown align="end">
    <flux:button icon:trailing="bell" variant="ghost"> </flux:button>
    <flux:menu>

        @forelse($notifications as $notification)
            <div class="px-4 py-2 border-b">
                {{ $notification->data['message'] }}
                <flux:menu.item wire:click="markAsRead('{{ $notification->id }}')" class="text-xs text-blue-500">Marcar lida</flux:menu.item>
            </div>
            <flux:menu.separator />
        @empty
            <div class="px-4 py-2 text-zinc-500 dark:text-zinc-100">Sem notificações</div>
        @endforelse
    </flux:menu>
</flux:dropdown>
</div>
