<?php

namespace Phpsa\FilamentAuthentication\Resources\RoleResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Spatie\Permission\Contracts\Role;
use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\EditRecord;
use Spatie\Permission\PermissionRegistrar;
use Phpsa\FilamentAuthentication\FilamentAuthentication;

class EditRole extends EditRecord
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

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
