<?php

namespace Phpsa\FilamentAuthentication;

use Livewire\Livewire;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Phpsa\FilamentAuthentication\Commands\InstallCommand;
use Phpsa\FilamentAuthentication\Pages\Auth\RenewPassword;
use Phpsa\FilamentAuthentication\Commands\UpdateUserPasswordToUpdatedCommand;
use Phpsa\FilamentAuthentication\Subscribers\AuthenticationLoggingSubscriber;

class FilamentAuthenticationProvider extends PackageServiceProvider
{
    public static string $name = 'filament-authentication';


    public function configurePackage(Package $package): void
    {
        $package->name('filament-authentication')
            ->hasViews()
            ->hasRoute('web')
            ->hasMigration('create_filament_authentication_tables')
            ->hasMigration('create_filament_password_renew_table')
            ->hasMigration('tracks_filament_password_hashes')
            ->hasConfigFile('filament-authentication')
            ->hasCommand(InstallCommand::class)
            ->hasCommand(UpdateUserPasswordToUpdatedCommand::class)
            ->hasTranslations();

        Event::subscribe(AuthenticationLoggingSubscriber::class);
    }

    public function packageBooted()
    {

        Livewire::component('phpsa.filament-authentication.pages.auth.renew-password', RenewPassword::class);

        parent::packageBooted();

        Arr::macro('pushBefore', function (array $existing, $key, $new): array {
            $keys = array_keys($existing);
            $index = array_search($key, $keys);
            $pos = false === $index ? count($existing) : $index - 1;
            return array_merge(array_slice($existing, 0, $pos), $new, array_slice($existing, $pos));
        });

        Arr::macro('pushAfter', function (array $existing, $key, $new): array {
            $keys = array_keys($existing);
            $index = array_search($key, $keys);
            $pos = false === $index ? count($existing) : $index + 1;
            return array_merge(array_slice($existing, 0, $pos), $new, array_slice($existing, $pos));
        });
    }
}
