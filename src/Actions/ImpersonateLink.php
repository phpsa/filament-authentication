<?php

namespace Phpsa\FilamentAuthentication\Actions;

use Filament\Facades\Filament;
use Illuminate\Routing\Redirector;
use Filament\Tables\Actions\Action;
use Illuminate\Http\RedirectResponse;
use Lab404\Impersonate\Services\ImpersonateManager;
use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Phpsa\FilamentAuthentication\FilamentAuthentication;

class ImpersonateLink
{
    public static function make(): Action
    {
        return Action::make('impersonate')
            ->label(__('filament-authentication::filament-authentication.button.impersonate'))
            ->icon('heroicon-o-identification')
            ->action(fn ($record) => static::impersonate($record))
            ->hidden(fn ($record) => ! static::allowed(Filament::auth()->user(), $record));
    }

    /**
     * Undocumented function
     *
     * @param  \Illuminate\Database\Eloquent\Model&\Illuminate\Contracts\Auth\Authenticatable  $current
     * @param  \Illuminate\Database\Eloquent\Model&\Illuminate\Contracts\Auth\Authenticatable  $target
     * @return bool
     */
    public static function allowed(User $current, User $target): bool
    {
        $enabled = FilamentAuthentication::getPlugin()->impersonateEnabled();
        return $enabled
        && $current->isNot($target)
        && ! app(ImpersonateManager::class)->isImpersonating()
        && (! method_exists($current, 'canImpersonate') || $current->canImpersonate())
        && (! method_exists($target, 'canBeImpersonated') || $target->canBeImpersonated());
    }

    /**
     *
     * @param  \Illuminate\Database\Eloquent\Model&\Illuminate\Contracts\Auth\Authenticatable $record
     * @return false|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public static function impersonate(User $record): false|Redirector|RedirectResponse
    {
        if (! static::allowed(Filament::auth()->user(), $record)) {
            return false;
        }

        app(ImpersonateManager::class)->take(
            Filament::auth()->user(),
            $record,
            FilamentAuthentication::getPlugin()->getImpersonateGuard()
        );

        session()->put('impersonate.back_to', url()->previous());

        session()->forget(array_unique([
            'password_hash_' . FilamentAuthentication::getPlugin()->getImpersonateGuard(),
            'password_hash_' . config('filament.auth.guard'),
        ]));

        return redirect(FilamentAuthentication::getPlugin()->getImpersonateRedirect());
    }

    public static function leave(): Redirector|RedirectResponse
    {

        if (! app(ImpersonateManager::class)->isImpersonating()) {
            return redirect('/');
        }

        app(ImpersonateManager::class)->leave();

        session()->forget(array_unique([
            'password_hash_' . FilamentAuthentication::getPlugin()->getImpersonateGuard(),
            'password_hash_' . config('filament.auth.guard'),
        ]));

        return redirect(
            session()->pull('impersonate.back_to') ?? '/'
        );
    }
}
