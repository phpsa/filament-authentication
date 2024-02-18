<?php

namespace Phpsa\FilamentAuthentication\Resources\RoleResource\Pages;

use Spatie\Permission\Contracts\Role;
use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\PermissionRegistrar;
use Phpsa\FilamentAuthentication\FilamentAuthentication;

class CreateRole extends CreateRecord
{
    public static function getResource(): string
    {
        return FilamentAuthentication::getPlugin()->getResource('RoleResource');
    }

    public function afterSave(): void
    {
        if (! $this->record instanceof Role) {
            return;
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
