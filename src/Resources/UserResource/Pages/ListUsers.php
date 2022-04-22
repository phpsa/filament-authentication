<?php

namespace Phpsa\FilamentAuthentication\Resources\UserResource\Pages;

use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    public static function getResource(): string
    {
        return Config::get('filament-authentication.resources.UserResource');
    }
}
