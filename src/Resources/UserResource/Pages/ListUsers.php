<?php

namespace Phpsa\FilamentAuthentication\Resources\UserResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Config;

class ListUsers extends ListRecords
{
    public static function getResource(): string
    {
        return Config::get('filament-authentication.resources.UserResource');
    }
}
