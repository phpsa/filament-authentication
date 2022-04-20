<?php

namespace  Phpsa\FilamentAuthentication\Resources\UserResource\Pages;

use Phpsa\FilamentAuthentication\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (empty($data['password'])) {
            unset($data['password']);
        }
        return $data;
    }
}
