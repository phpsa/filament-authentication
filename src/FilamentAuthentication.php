<?php

namespace Phpsa\FilamentAuthentication;

use Filament\Navigation\MenuItem;
use Filament\Panel;

class FilamentAuthentication
{
    public static function resources(array $with = []): array
    {
        return array_merge(
            config('filament-authentication.resources'),
            $with
        );
    }
}
