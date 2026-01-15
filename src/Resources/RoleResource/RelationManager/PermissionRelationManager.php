<?php

namespace Phpsa\FilamentAuthentication\Resources\RoleResource\RelationManager;

use Filament\Schemas\Schema;
use Filament\Actions\CreateAction;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Spatie\Permission\PermissionRegistrar;
use Filament\Resources\RelationManagers\RelationManager;
use Phpsa\FilamentAuthentication\FilamentAuthentication;

class PermissionRelationManager extends RelationManager
{
    protected static string $relationship = 'permissions';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                ->required()
                    ->label(strval(__('filament-authentication::filament-authentication.field.name'))),
                TextInput::make('guard_name')
                ->required()
                    ->label(strval(__('filament-authentication::filament-authentication.field.guard_name')))
                    ->default(config('auth.defaults.guard')),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(strval(__('filament-authentication::filament-authentication.field.name')))
                    ->searchable(),
                TextColumn::make('guard_name')
                    ->label(strval(__('filament-authentication::filament-authentication.field.guard_name'))),

            ])
            ->headerActions([
                CreateAction::make(),
                AttachAction::make()
                    ->preloadRecordSelect(FilamentAuthentication::getPlugin()->getPreloadPermissions())
                    ->recordSelect(fn($select) => $select->multiple())
                    ->closeModalByClickingAway(false),
            ])
            ->recordActions([
                DetachAction::make()
            ])

            ->toolbarActions([

                DetachBulkAction::make(),

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
