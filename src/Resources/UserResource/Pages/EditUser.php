<?php

namespace  Phpsa\FilamentAuthentication\Resources\UserResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\EditRecord;
use Phpsa\FilamentAuthentication\Events\UserUpdated;

class EditUser extends EditRecord
{
    public static function getResource(): string
    {
        return Config::get('filament-authentication.resources.UserResource');
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
        ];
    }
}
