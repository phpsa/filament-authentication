<?php

namespace Phpsa\FilamentAuthentication\Resources\AuthenticationLogResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Phpsa\FilamentAuthentication\FilamentAuthentication;

class ListAuthenticationLogs extends ListRecords
{
    public static function getResource(): string
    {
        return FilamentAuthentication::getPlugin()->getResource('AuthenticationLogResource');
    }
}
