<?php

namespace Phpsa\FilamentAuthentication\Resources;

use Phpsa\FilamentAuthentication\Resources\PermissionResource\Pages\CreatePermission;
use Phpsa\FilamentAuthentication\Resources\PermissionResource\Pages\EditPermission;
use Phpsa\FilamentAuthentication\Resources\PermissionResource\Pages\ListPermissions;
use Phpsa\FilamentAuthentication\Resources\PermissionResource\Pages\ViewPermission;
use Phpsa\FilamentAuthentication\Resources\PermissionResource\RelationManager\RoleRelationManager;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';

    public function __construct()
    {
        static::$model = config('filament-authentication.models.Permission');
    }

    public static function getLabel(): string
    {
        return strval(__('filament-authentication::filament-authentication.section.permission'));
    }

    protected static function getNavigationGroup(): ?string
    {
        return strval(__('filament-authentication::filament-authentication.section.group'));
    }

    public static function getPluralLabel(): string
    {
        return strval(__('filament-authentication::filament-authentication.section.permissions'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label(strval(__('filament-authentication::filament-authentication.field.name'))),
                            TextInput::make('guard_name')
                                ->label(strval(__('filament-authentication::filament-authentication.field.guard_name')))
                                 ->default(config('auth.defaults.guard')),
                            // BelongsToManyMultiSelect::make('roles')
                            //     ->label(strval(__('filament-authentication::filament-authentication.field.roles')))
                            //     ->relationship('roles', 'name')
                            //     ->preload(config('filament-spatie-roles-permissions.preload_roles'))
                        ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('name')
                    ->label(strval(__('filament-authentication::filament-authentication.field.name')))
                    ->searchable(),
                TextColumn::make('guard_name')
                    ->label(strval(__('filament-authentication::filament-authentication.field.guard_name')))
                    ->searchable(),
            ])
            ->filters([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RoleRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListPermissions::route('/'),
            'create' => CreatePermission::route('/create'),
            'edit'   => EditPermission::route('/{record}/edit'),
            'view'   => ViewPermission::route('/{record}')
        ];
    }
}
