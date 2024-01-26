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

    protected array $widgets = [
        LatestUsersWidget::class,
    ];

    protected function getResources(): array
    {
        return config('filament-authentication.resources');
    }

    protected function getWidgets(): array
    {
        return config('filament-authentication.resources.widgets');
    }

    public function configurePackage(Package $package): void
    {
        Config::push('filament.middleware.base', ImpersonatingMiddleware::class);

        $package->name('filament-authentication')
            ->hasConfigFile()
            ->hasViews()
            ->hasRoute('web')
            ->hasTranslations();
    }

    public function getPages(): array
    {
        return config('filament-authentication.pages');
    }

    public function packageRegistered(): void
    {

        TextColumn::macro('humanDate', function () {
            /** @var \Filament\Tables\Columns\TextColumn&\Filament\Tables\Columns\Concerns\CanFormatState $this */
            $this->formatStateUsing(fn ($state): ?string => $state ? $state->diffForHumans() : null);

            return $this;
        });
    }
}
