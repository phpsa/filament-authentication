<?php

namespace Phpsa\FilamentAuthentication\Resources\UserResource\Pages;

use Filament\Actions\CreateAction;
use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    public static function getResource(): string
    {
        return Config::get('filament-authentication.resources.UserResource');
    }

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
