<?php

namespace Phpsa\FilamentAuthentication\Actions;

use Livewire\Redirector;
use Filament\Facades\Filament;
use Filament\Tables\Actions\Action;
use Lab404\Impersonate\Impersonate;
use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Http\RedirectResponse;
use Lab404\Impersonate\Services\ImpersonateManager;

class ImpersonateLink
{
    public static function make(): Action
    {
        return Filament::makeTableAction('impersonate')
            ->label(__('filament-authentication::filament-authentication.button.impersonate'))
            ->icon('heroicon-o-identification')
            ->action(fn($record) => static::impersonate($record))
            ->hidden(fn($record) => ! static::allowed(Filament::auth()->user(), $record));
        ;
    }

    /**
     * Undocumented function
     *
     * @param Illuminate\Contracts\Auth\Authenticatable $current
     * @param Illuminate\Contracts\Auth\Authenticatable&\Lab404\Impersonate\Models\Impersonate $target
     *
     * @return bool
     */
    public static function allowed(User $current, User $target): bool
    {
        return config('filament-authentication.impersonate.enabled', false)
        && $current->isNot($target)
        && ! app(ImpersonateManager::class)->isImpersonating()
        && (! method_exists($current, 'canImpersonate') || $current->canImpersonate())
        && (! method_exists($target, 'canBeImpersonated') || $target->canBeImpersonated());
    }

    public static function impersonate(User $record): bool|Redirector|RedirectResponse
    {
        if (! static::allowed(Filament::auth()->user(), $record)) {
            return false;
        }

        app(ImpersonateManager::class)->take(
            Filament::auth()->user(),
            $record,
            config('filament-authentication.impersonate.guard', 'web')
        );

        session()->forget(array_unique([
            'password_hash_' . config('filament-authentication.impersonate.guard', 'web'),
            'password_hash_' . config('filament.auth.guard')
        ]));

        return redirect(config('filament-authentication.impersonate.redirect', "/"));
    }

    public static function leave(): bool|Redirector|RedirectResponse
    {

        if (! app(ImpersonateManager::class)->isImpersonating()) {
            return redirect('/');
        }

        app(ImpersonateManager::class)->leave();

        session()->forget(array_unique([
            'password_hash_' . config('filament-authentication.impersonate.guard'),
            'password_hash_' . config('filament.auth.guard')
        ]));

        return redirect(
            session()->pull('impersonate.back_to') ?? config('filament.path')
        );
    }
}
