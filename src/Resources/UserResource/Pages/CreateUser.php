<?php

namespace  Phpsa\FilamentAuthentication\Resources\UserResource\Pages;

use Phpsa\FilamentAuthentication\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
