<?php

namespace Phpsa\FilamentAuthentication\Resources\PermissionResource\Pages;

use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Contracts\Permission;
use Phpsa\FilamentAuthentication\FilamentAuthentication;

class CreatePermission extends CreateRecord
{
    public static function getResource(): string
    {
        return FilamentAuthentication::getPlugin()->getResource('PermissionResource');
    }

    public function afterSave(): void
    {
        if (! $this->record instanceof Permission) {
            return;
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
