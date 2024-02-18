<?php

namespace Phpsa\FilamentAuthentication\Resources\RoleResource\Pages;

use Filament\Actions\EditAction;
use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\ViewRecord;
use Phpsa\FilamentAuthentication\FilamentAuthentication;

class ViewRole extends ViewRecord
{
    public static function getResource(): string
    {
        return FilamentAuthentication::getPlugin()->getResource('RoleResource');
    }

    protected function getHeaderActions(): array
    {
        return[
            EditAction::make(),
        ];
    }
}
