<?php

namespace Phpsa\FilamentAuthentication\Resources\PermissionResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Config;

class ViewPermission extends ViewRecord
{
    public static function getResource(): string
    {
        return Config::get('filament-authentication.resources.PermissionResource');
    }
}
