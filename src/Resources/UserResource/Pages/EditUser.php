<?php

namespace  Phpsa\FilamentAuthentication\Resources\UserResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\EditRecord;
use Phpsa\FilamentAuthentication\Events\UserUpdated;
use Phpsa\FilamentAuthentication\FilamentAuthentication;

class EditUser extends EditRecord
{
    public static function getResource(): string
    {
        return FilamentAuthentication::getPlugin()->getResource('UserResource');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (empty($data['password'])) {
            unset($data['password']);
        }

        return $data;
    }

    protected function afterSave(): void
    {
        Event::dispatch(new UserUpdated($this->record));
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
