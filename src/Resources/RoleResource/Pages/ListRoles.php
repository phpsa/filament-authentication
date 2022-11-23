<?php

namespace Phpsa\FilamentAuthentication\Resources\RoleResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Config;

class ListRoles extends ListRecords
{
    public static function getResource(): string
    {
        return Config::get('filament-authentication.resources.RoleResource');
    }
}
