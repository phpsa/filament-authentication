<?php

namespace Phpsa\FilamentAuthentication\Resources\RoleResource\Pages;

use Filament\Actions\CreateAction;
use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\ListRecords;

class ListRoles extends ListRecords
{
    public static function getResource(): string
    {
        return Config::get('filament-authentication.resources.RoleResource');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
