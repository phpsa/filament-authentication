<x-filament-panels::page.simple>
    <x-filament-panels::form wire:submit="renew">
        {{ $this->form }}

        <x-filament-panels::form.actions
                :actions="$this->getFormActions()"
                :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>

</x-filament-panels::page.simple>
