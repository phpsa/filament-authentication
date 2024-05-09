<?php

namespace Phpsa\FilamentAuthentication;

use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\Facades\Config;
use Filament\Tables\Columns\TextColumn;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Phpsa\FilamentAuthentication\Widgets\LatestUsersWidget;
use Phpsa\FilamentAuthentication\Http\Middleware\ImpersonatingMiddleware;

class FilamentAuthenticationProvider extends PackageServiceProvider
{
    public static string $name = 'filament-authentication';


    public function configurePackage(Package $package): void
    {
        $package->name('filament-authentication')
            ->hasViews()
            ->hasRoute('web')
            ->hasMigration('create_filament_authentication_tables')
            ->hasConfigFile('filament-authentication')
            ->hasCommand(InstallCommand::class)
            ->hasTranslations();
        Event::subscribe(AuthenticationLoggingSubscriber::class);
    }
}
