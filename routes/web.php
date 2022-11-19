<?php

use Illuminate\Support\Facades\Route;
use Phpsa\FilamentAuthentication\Actions\ImpersonateLink;

Route::get('/impersonate/stop', fn () => ImpersonateLink::leave())
    ->name('filament-authentication.stop.impersonation')
    ->middleware(config('filament-authentication.impersonate.guard'));
