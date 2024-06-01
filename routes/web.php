<?php

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;
use Phpsa\FilamentAuthentication\Actions\ImpersonateLink;
use Phpsa\FilamentAuthentication\Pages\Auth\RenewPassword;

Route::name('filament.')->group(function () {
    foreach (Filament::getPanels() as $panel) {
        if ($panel->hasPlugin('filament-authentication') === false) {
            continue;
        }

        /** @var \Phpsa\FilamentAuthentication\FilamentAuthentication */
        $plugin = $panel->getPlugin('filament-authentication');

        $domains = $panel->getDomains();

        foreach ((empty($domains) ? [null] : $domains) as $domain) {
            Route::domain($domain)
                ->middleware($panel->getMiddleware())
                ->name($panel->getId() . '.')
                ->prefix($panel->getPath())
                ->group(function () use ($panel, $plugin) {

                    if ($plugin->impersonateEnabled()) {
                        Route::get('/impersonate/stop', fn () => ImpersonateLink::leave())
                        ->name('fa.stop.impersonation');
                    }

                    if ((int) config('filament-authentication.password_renew.renew_password_days_period', 0) > 0) {
                        Route::get('password/renew', RenewPassword::class)->name('fa.password.renew');
                    }
                });
        }
    }
});
