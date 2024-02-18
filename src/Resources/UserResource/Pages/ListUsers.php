<?php

namespace Phpsa\FilamentAuthentication\Resources\UserResource\Pages;

use Filament\Actions\CreateAction;
use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\ListRecords;
use Phpsa\FilamentAuthentication\FilamentAuthentication;

class ListUsers extends ListRecords
{
    public static function getResource(): string
    {
        return FilamentAuthentication::getPlugin()->getResource('UserResource');
    }

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
