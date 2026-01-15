<?php

namespace Phpsa\FilamentAuthentication\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Spatie\Permission\Models\Permission;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use Phpsa\FilamentAuthentication\FilamentAuthentication;
use Phpsa\FilamentAuthentication\Resources\PermissionResource\Pages\EditPermission;
use Phpsa\FilamentAuthentication\Resources\PermissionResource\Pages\ViewPermission;
use Phpsa\FilamentAuthentication\Resources\PermissionResource\Pages\ListPermissions;
use Phpsa\FilamentAuthentication\Resources\PermissionResource\Pages\CreatePermission;
use Phpsa\FilamentAuthentication\Resources\PermissionResource\RelationManager\RoleRelationManager;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    public static function getModel(): string
    {
        return FilamentAuthentication::getPlugin()->getModel('Permission');
    }

    public static function getLabel(): string
    {
        return strval(__('filament-authentication::filament-authentication.section.permission'));
    }

    public static function getNavigationGroup(): ?string
    {
        return strval(__(config('filament-authentication.section.group') ?? 'filament-authentication::filament-authentication.section.group'));
    }

    public static function getPluralLabel(): string
    {
        return strval(__('filament-authentication::filament-authentication.section.permissions'));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return config('filament-authentication.navigation.permission.register', true);
    }

    public static function getNavigationIcon(): string
    {
        return config('filament-authentication.navigation.permission.icon');
    }

    public static function getNavigationSort(): ?int
    {
        return config('filament-authentication.navigation.permission.sort');
    }


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->required()
                                ->label(strval(__('filament-authentication::filament-authentication.field.name'))),
                            TextInput::make('guard_name')
                                ->required()
                                ->label(strval(__('filament-authentication::filament-authentication.field.guard_name')))
                                ->default(config('auth.defaults.guard')),

                        ]),
                    ]),
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
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RoleRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListPermissions::route('/'),
            'create' => CreatePermission::route('/create'),
            'edit'   => EditPermission::route('/{record}/edit'),
            'view'   => ViewPermission::route('/{record}'),
        ];
    }
}
