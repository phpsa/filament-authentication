<?php

namespace Phpsa\FilamentAuthentication\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Lab404\Impersonate\Services\ImpersonateManager;
use Phpsa\FilamentAuthentication\FilamentAuthentication;
use Phpsa\FilamentAuthentication\Traits\CanRenewPassword;

class RenewPasswordMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $user = $request->user();

        $ignore = ! ($response instanceof Response) || $user === null
        || $request->routeIs(
            Filament::getCurrentPanel()->generateRouteName('auth.logout')
        )
        || $request->routeIs(
            Filament::getCurrentPanel()->generateRouteName('fa.password.renew')
        )
        || app(ImpersonateManager::class)->isImpersonating()
        || ! in_array(
            CanRenewPassword::class,
            class_uses_recursive(FilamentAuthentication::getPlugin()->getModel('User'))
        ) || ! $user->needsRenewal(); //@phpstan-ignore method.notFound (part of trait)

        // Only touch illuminate responses (avoid binary, etc)
        if ($ignore) {
            return $response;
        }

        if ($request->wantsJson()) {
            $response->header('X-Needs-Password-Renewal', 'true');
            return $response;
        }

        $panelId = Filament::getCurrentPanel()->getId();
        return Redirect::guest(URL::route("filament.{$panelId}.fa.password.renew"));
    }
}
