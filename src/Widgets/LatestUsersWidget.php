<?php

namespace Phpsa\FilamentAuthentication\Widgets;

use App\Models\User;
use Filament\Widgets\TableWidget;
use Illuminate\Support\Facades\Config;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class LatestUsersWidget extends TableWidget
{
    protected function getTableQuery(): Builder
    {
        return User::query()
        ->latest()
        ->limit(Config::get('filament-authentication.Widgets.LatestUsers.limit'));
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')
                ->label("ID"),
            TextColumn::make('name')
                ->label(strval(__('filament-authentication::filament-authentication.field.user.name'))),
            TextColumn::make('created_at')
                ->humanDate()
                ->label(strval(__('filament-authentication::filament-authentication.field.user.created_at')))
        ];
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }

    public static function canView(): bool
    {
        return Config::get('filament-authentication.Widgets.LatestUsers.enabled', true)
        && static::getResource()::canViewAny();
    }

    public static function getResource(): string
    {
        return Config::get('filament-authentication.resources.UserResource');
    }

    public static function getSort(): int
    {
        return Config::get('filament-authentication.Widgets.LatestUsers.sort', 0);
    }
}
