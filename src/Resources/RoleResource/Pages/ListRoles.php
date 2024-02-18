<?php

namespace Phpsa\FilamentAuthentication\Resources\RoleResource\Pages;

use Filament\Actions\CreateAction;
use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\ListRecords;
use Phpsa\FilamentAuthentication\FilamentAuthentication;

class ListRoles extends ListRecords
{
    public static function getResource(): string
    {
        return FilamentAuthentication::getPlugin()->getResource('RoleResource');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
