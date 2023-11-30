<?php

namespace Phpsa\FilamentAuthentication\Resources\PermissionResource\Pages;

use Filament\Actions\EditAction;
use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\ViewRecord;

class ViewPermission extends ViewRecord
{
    public static function getResource(): string
    {
        return Config::get('filament-authentication.resources.PermissionResource');
    }

    protected function getHeaderActions(): array
    {
        return[
            EditAction::make(),
        ];
    }
}
