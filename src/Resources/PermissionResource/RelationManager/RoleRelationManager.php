<?php

namespace Phpsa\FilamentAuthentication\Resources\PermissionResource\RelationManager;

use Filament\Schemas\Schema;
use Filament\Actions\CreateAction;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Spatie\Permission\PermissionRegistrar;
use Filament\Resources\RelationManagers\RelationManager;
use Phpsa\FilamentAuthentication\FilamentAuthentication;

class RoleRelationManager extends RelationManager
{
    protected static string $relationship = 'roles';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(strval(__('filament-authentication::filament-authentication.field.name'))),
                TextInput::make('guard_name')
                    ->label(strval(__('filament-authentication::filament-authentication.field.guard_name')))
                     ->default(config('auth.defaults.guard')),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(strval(__('filament-authentication::filament-authentication.field.name'))),
                TextColumn::make('guard_name')
                    ->label(strval(__('filament-authentication::filament-authentication.field.guard_name'))),

            ])
            ->headerActions([
                CreateAction::make(),
                AttachAction::make()->preloadRecordSelect(FilamentAuthentication::getPlugin()->getPreloadRoles())
                ->recordSelect(fn($select) => $select->multiple())
                ->closeModalByClickingAway(false),
            ])
            ->recordActions([
                DetachAction::make()
            ])

            ->toolbarActions([

                DissociateBulkAction::make(),

            ]);
    }

    public function afterAttach(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function afterDetach(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
