<?php

namespace Phpsa\FilamentAuthentication\Resources\RoleResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\PermissionRegistrar;

class EditRole extends EditRecord
{
    public static function getResource(): string
    {
        return Config::get('filament-authentication.resources.RoleResource');
    }

    public function afterSave(): void
    {
        if (! $this->record instanceof Role) {
            return;
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
