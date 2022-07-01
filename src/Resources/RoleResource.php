<?php

namespace Phpsa\FilamentAuthentication\Resources;

use Phpsa\FilamentAuthentication\Resources\RoleResource\Pages\CreateRole;
use Phpsa\FilamentAuthentication\Resources\RoleResource\Pages\EditRole;
use Phpsa\FilamentAuthentication\Resources\RoleResource\Pages\ListRoles;
use Phpsa\FilamentAuthentication\Resources\RoleResource\Pages\ViewRole;
use Phpsa\FilamentAuthentication\Resources\RoleResource\RelationManager\PermissionRelationManager;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public function __construct()
    {
        static::$model = config('filament-authentication.models.Role');
    }

    public static function getLabel(): string
    {
        return strval(__('filament-authentication::filament-authentication.section.role'));
    }

    protected static function getNavigationGroup(): ?string
    {
        return strval(__('filament-authentication::filament-authentication.section.group'));
    }

    public static function getPluralLabel(): string
    {
        return strval(__('filament-authentication::filament-authentication.section.roles'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label(strval(__('filament-authentication::filament-authentication.field.name'))),
                                TextInput::make('guard_name')
                                    ->label(strval(__('filament-authentication::filament-authentication.field.guard_name')))
                                    ->default(config('auth.defaults.guard')),
                                // BelongsToManyMultiSelect::make('permissions')
                                //     ->label(strval(__('filament-authentication::filament-authentication.field.permissions')))
                                //     ->relationship('permissions', 'name')
                                //     ->hidden()
                                //     ->preload(config('filament-spatie-roles-permissions.preload_permissions'))
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
            PermissionRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'edit'   => EditRole::route('/{record}/edit'),
            'view'   => ViewRole::route('/{record}')
        ];
    }
}
