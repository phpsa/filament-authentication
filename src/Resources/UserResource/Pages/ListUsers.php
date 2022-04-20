<?php

namespace Phpsa\FilamentAuthentication\Resources\UserResource\Pages;

use Phpsa\FilamentAuthentication\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;
}
