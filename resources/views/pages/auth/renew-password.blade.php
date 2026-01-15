<x-filament-panels::page.simple>
    @if (filament()->hasLogin())
        <x-slot name="subheading">
            {{ __('filament-panels::pages/auth/password-reset/request-password-reset.actions.login.label') }}

            {{ $this->loginAction }}
        </x-slot>
    @endif

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
