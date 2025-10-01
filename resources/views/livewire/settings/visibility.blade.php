<section class="w-full container mx-auto">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Visibility')" :subheading="__('Change the visibility of your collections and information.')">
        <flux:fieldset>
            <flux:legend>{{ __('Configurações de Visibilidade') }}</flux:legend>
            <div class="space-y-4">
                <flux:switch wire:model.live="is_private"
                             label="{{ __('Perfil privado') }}"
                             description="{{ __('Apenas usuários aprovados poderão ver seu perfil, coleções e atividades.') }}" />
                <flux:separator variant="subtle" />

                <flux:switch wire:model.live="hide_collections"
                             label="{{ __('Ocultar coleções') }}"
                             description="{{ __('Suas coleções não serão visíveis para outros usuários.') }}" />
                <flux:separator variant="subtle" />

                <flux:switch wire:model.live="hide_followers"
                             label="{{ __('Ocultar seguidores') }}"
                             description="{{ __('Ninguém poderá ver quem te segue.') }}" />
                <flux:separator variant="subtle" />

                <flux:switch wire:model.live="hide_following"
                             label="{{ __('Ocultar seguindo') }}"
                             description="{{ __('Ninguém poderá ver a lista de usuários que você segue.') }}" />
            </div>
        </flux:fieldset>
    </x-settings.layout>


</section>
