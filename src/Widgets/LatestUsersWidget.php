<?php

namespace Phpsa\FilamentAuthentication\Widgets;

use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Support\Facades\Config;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Phpsa\FilamentAuthentication\FilamentAuthentication;

class LatestUsersWidget extends TableWidget
{
    public int $limit = 5;
    public bool $paginate = false;

    protected function getTableQuery(): Builder
    {
        return $this->getResource()::getEloquentQuery()
            ->latest()
            ->limit($this->limit);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')
                ->label('ID'),
            TextColumn::make('name')
                ->label(strval(__('filament-authentication::filament-authentication.field.user.name'))),
            //@phpstan-ignore method.notFound (macro in package)
            TextColumn::make('created_at')
                ->humanDate()
                ->label(strval(__('filament-authentication::filament-authentication.field.user.created_at'))),
        ];
    }

    protected function isTablePaginationEnabled(): bool
    {
        return $this->paginate;
    }

    public static function canView(): bool
    {
        return static::getResource()::canViewAny();
    }

    public static function getResource(): string
    {
        return FilamentAuthentication::getPlugin()->getResource('UserResource');
    }
}
