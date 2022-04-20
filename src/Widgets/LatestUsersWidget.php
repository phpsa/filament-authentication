<?php

namespace Phpsa\FilamentAuthentication\Widgets;

use App\Models\User;
use Filament\Widgets\TableWidget;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Contracts\Database\Eloquent\Builder;

class LatestUsersWidget extends TableWidget
{
    protected function getTableQuery(): Builder
    {
        return User::query()->latest()->limit(10);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')->label("ID"),
            TextColumn::make('name') ->label(__('filament-authentication::filament-authentication.field.user.name')),
            TextColumn::make('created_at')->humanDate() ->label(__('filament-authentication::filament-authentication.field.user.created_at'))
        ];
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }
}
