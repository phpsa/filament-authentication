<?php

namespace Phpsa\FilamentAuthentication\Resources\UserResource\Pages;

use Filament\Facades\Filament;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\UnauthorizedException;
use Phpsa\FilamentAuthentication\Actions\ImpersonateLink;

class ViewUser extends ViewRecord
{
    public static function getResource(): string
    {
        return Config::get('filament-authentication.resources.UserResource');
    }

    protected function getHeaderActions(): array
    {
        return collect([
            EditAction::make(),
            $this->impersonateAction(),
        ])->filter()->toArray();
    }

    protected function impersonateAction(): ?Action
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable */
        $record = $this->getRecord();
        $user = Filament::auth()->user();
        if ($user === null || ImpersonateLink::allowed($user, $record) === false) {
            return null;
        }

        return Action::make('impersonate')
            ->label(__('filament-authentication::filament-authentication.button.impersonate'))
            ->action(fn() => ImpersonateLink::impersonate($record));
    }
}
