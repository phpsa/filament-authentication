<?php

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;
use Phpsa\FilamentAuthentication\Actions\ImpersonateLink;
use Phpsa\FilamentAuthentication\Pages\Auth\RenewPassword;

Route::get('/impersonate/stop', fn () => ImpersonateLink::leave())
    ->name('filament-authentication.stop.impersonation')
    ->middleware('web');



Route::name('filament.')->group(function () {
    foreach (Filament::getPanels() as $panel) {
        $domains = $panel->getDomains();

        foreach ((empty($domains) ? [null] : $domains) as $domain) {
            Route::domain($domain)
                ->middleware($panel->getMiddleware())
                ->name($panel->getId() . '.')
                ->prefix($panel->getPath())
                ->group(function () use ($panel) {
                    Route::get('password/renew', RenewPassword::class)->name('auth.password.renew');
                });
        }
    }
});
