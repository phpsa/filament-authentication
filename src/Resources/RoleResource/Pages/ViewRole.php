<?php

namespace Phpsa\FilamentAuthentication\Resources\RoleResource\Pages;

use Filament\Actions\EditAction;
use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\ViewRecord;

class ViewRole extends ViewRecord
{
    public static function getResource(): string
    {
        return Config::get('filament-authentication.resources.RoleResource');
    }

    protected function getHeaderActions(): array
    {
        return[
            EditAction::make(),
        ];
    }
}
