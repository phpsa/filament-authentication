<?php

namespace Phpsa\FilamentAuthentication\Resources\PermissionResource\Pages;

use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Config;
use Filament\Tables\Actions\BulkAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Collection;

class ListPermissions extends ListRecords
{
    public static function getResource(): string
    {
        return Config::get('filament-authentication.resources.PermissionResource');
    }


    protected function getTableBulkActions(): array
    {
        return [
            BulkAction::make('Attach Role')
            ->action(function (Collection $records, array $data): void {
                // dd($data);
                foreach ($records as $record) {
                    $record->roles()->sync($data['role']);
                    $record->save();
                }
            })
            ->form([
                Select::make('role')
                    ->label(__('filament-authentication::filament-authentication.field.role'))
                    ->options(Role::query()->pluck('name', 'id'))
                    ->required(),
            ])->deselectRecordsAfterCompletion()
        ];
    }
}
