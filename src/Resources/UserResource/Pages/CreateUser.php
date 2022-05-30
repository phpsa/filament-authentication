<?php

namespace  Phpsa\FilamentAuthentication\Resources\UserResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Phpsa\FilamentAuthentication\Events\UserCreated;

class CreateUser extends CreateRecord
{
    public static function getResource(): string
    {
        return Config::get('filament-authentication.resources.UserResource');
    }

    protected function afterCreate(): void
    {
        Event::dispatch(new UserCreated($this->record));
    }
}
