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
use Spatie\Permission\Models\Role;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Phpsa\FilamentAuthentication\FilamentAuthentication;
use Phpsa\FilamentAuthentication\Resources\RoleResource\Pages\EditRole;
use Phpsa\FilamentAuthentication\Resources\RoleResource\Pages\ViewRole;
use Phpsa\FilamentAuthentication\Resources\RoleResource\Pages\ListRoles;
use Phpsa\FilamentAuthentication\Resources\RoleResource\Pages\CreateRole;
use Phpsa\FilamentAuthentication\Resources\RoleResource\RelationManager\UserRelationManager;
use Phpsa\FilamentAuthentication\Resources\RoleResource\RelationManager\PermissionRelationManager;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    public static function getModel(): string
    {
        return FilamentAuthentication::getPlugin()->getModel('Role');
    }

    public static function getLabel(): string
    {
        return strval(__('filament-authentication::filament-authentication.section.role'));
    }

    public static function getNavigationGroup(): ?string
    {
        return strval(__(config('filament-authentication.section.group') ?? 'filament-authentication::filament-authentication.section.group'));
    }

    public static function getPluralLabel(): string
    {
        return strval(__('filament-authentication::filament-authentication.section.roles'));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return config('filament-authentication.navigation.role.register', true);
    }

    public static function getNavigationIcon(): string
    {
        return config('filament-authentication.navigation.role.icon');
    }

    public static function getNavigationSort(): ?int
    {
        return config('filament-authentication.navigation.role.sort');
    }


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label(strval(__('filament-authentication::filament-authentication.field.name')))
                                    ->required(),
                                TextInput::make('guard_name')
                                    ->label(strval(__('filament-authentication::filament-authentication.field.guard_name')))
                                    ->required()
                                    ->default(config('auth.defaults.guard')),

                            ]),
                    ])
                    ->columnSpanFull(),
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
                SelectFilter::make('guard_name')
        ->multiple()
        ->options(fn() => collect(config('auth.guards'))->keys()->mapWithKeys(fn($g) => [$g => $g])->toArray())
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
            PermissionRelationManager::class,
            UserRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'edit'   => EditRole::route('/{record}/edit'),
            'view'   => ViewRole::route('/{record}'),
        ];
    }
}
