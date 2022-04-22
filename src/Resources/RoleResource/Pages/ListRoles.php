<?php

namespace Phpsa\FilamentAuthentication\Resources\RoleResource\Pages;

use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\ListRecords;

class ListRoles extends ListRecords
{
    public static function getResource(): string
    {
        return Config::get('filament-authentication.resources.RoleResource');
    }
}
