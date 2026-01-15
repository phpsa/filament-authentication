<x-filament-panels::page.simple>
    <form wire:submit="renew">
        {{ $this->form }}

        <x-filament::button
            type="submit"
            class="w-full mt-6"
        >
            {{ __('filament-authentication::filament-authentication.pages.renew-password.actions.renew.label') }}
        </x-filament::button>
    </form>
</x-filament-panels::page.simple>
