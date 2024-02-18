<?php

namespace Phpsa\FilamentAuthentication\Resources\PermissionResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\EditRecord;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Contracts\Permission;
use Phpsa\FilamentAuthentication\FilamentAuthentication;

class EditPermission extends EditRecord
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

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
