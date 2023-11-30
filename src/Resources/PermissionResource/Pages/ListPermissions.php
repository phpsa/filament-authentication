<?php

namespace Phpsa\FilamentAuthentication\Resources\PermissionResource\Pages;

use Filament\Actions\CreateAction;
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

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    // protected function getTableBulkActions(): array
    // {
    //     $roleClass = config('filament-authentication.models.Role');

    //     return [
    //         BulkAction::make('Attach Role')
    //         ->action(function (Collection $records, array $data): void {
    //             // dd($data);
    //             foreach ($records as $record) {
    //                 $record->roles()->sync($data['role']);
    //                 $record->save();
    //             }
    //         })
    //         ->form([
    //             Select::make('role')
    //                 ->label(strval(__('filament-authentication::filament-authentication.field.role')))
    //                 ->options((new $roleClass())::query()->pluck('name', 'id'))
    //                 ->required(),
    //         ])->deselectRecordsAfterCompletion(),
    //     ];
    // }
}
