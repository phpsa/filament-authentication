<?php

namespace Phpsa\FilamentAuthentication\Resources\PermissionResource\Pages;

use Filament\Actions\EditAction;
use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\ViewRecord;
use Phpsa\FilamentAuthentication\FilamentAuthentication;

class ViewPermission extends ViewRecord
{
    public static function getResource(): string
    {
        return FilamentAuthentication::getPlugin()->getResource('PermissionResource');
    }

    protected function getHeaderActions(): array
    {
        return[
            EditAction::make(),
        ];
    }
}
