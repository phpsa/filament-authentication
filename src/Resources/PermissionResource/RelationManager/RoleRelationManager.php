<?php

namespace Phpsa\FilamentAuthentication\Resources\PermissionResource\RelationManager;

use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DetachAction;
use Spatie\Permission\PermissionRegistrar;
use Filament\Tables\Actions\DissociateBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Phpsa\FilamentAuthentication\FilamentAuthentication;

class RoleRelationManager extends RelationManager
{
    protected static string $relationship = 'roles';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
            ->actions([
                DetachAction::make()
            ])

            ->bulkActions([

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
