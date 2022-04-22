<?php

namespace  Phpsa\FilamentAuthentication\Resources\UserResource\Pages;

use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\EditRecord;

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
}
