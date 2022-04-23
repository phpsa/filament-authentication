<?php

namespace Phpsa\FilamentAuthentication\Resources\UserResource\Pages;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Config;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\ViewRecord;
use Lab404\Impersonate\Impersonate;
use Phpsa\FilamentAuthentication\Actions\ImpersonateLink;
use Phpsa\FilamentAuthentication\Resources\UserResource\RelationManager\RoleRelationManager;

class ViewUser extends ViewRecord
{
    public static function getResource(): string
    {
        return Config::get('filament-authentication.resources.UserResource');
    }

    protected function getActions(): array
    {

        if (ImpersonateLink::allowed(Filament::auth()->user(), $this->record)) {
            return array_merge([
                ButtonAction::make('impersonate')
                ->action(function () {
                    ImpersonateLink::impersonate($this->record);
                }),
            ], parent::getActions());
        }
        return parent::getActions();
    }
}
