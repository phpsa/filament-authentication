<?php

namespace Phpsa\FilamentAuthentication\Resources\PermissionResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\PermissionRegistrar;

class EditPermission extends EditRecord
{
    public static function getResource(): string
    {
        return Config::get('filament-authentication.resources.PermissionResource');
    }

    public function afterSave(): void
    {
        if (! $this->record instanceof Permission) {
            return;
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
