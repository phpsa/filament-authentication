<x-filament::page>
    <form wire:submit.prevent="submit" class="space-y-6">
        {{ $this->form }}

        <div class="flex flex-wrap items-center gap-4 justify-end">
            <x-filament::button type="submit">
            {{ __('filament::resources/pages/edit-record.form.actions.save.label') }}
            </x-filament::button>


            <x-filament::button type="button" color="secondary" tag="a" :href="$this->cancel_button_url">
                {{__('filament::resources/pages/edit-record.form.actions.cancel.label')}}
            </x-filament::button>
        </div>
    </form>
</x-filament::page>
