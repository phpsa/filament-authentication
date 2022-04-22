<?php

namespace Phpsa\FilamentAuthentication\Resources\UserResource\Pages;

use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\ViewRecord;
use Phpsa\FilamentAuthentication\Resources\UserResource\RelationManager\RoleRelationManager;

class ViewUser extends ViewRecord
{
    public static function getResource(): string
    {
        return Config::get('filament-authentication.resources.UserResource');
    }
}
