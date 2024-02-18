<?php

namespace Phpsa\FilamentAuthentication\Resources\RoleResource\RelationManager;

use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DetachAction;
use Spatie\Permission\PermissionRegistrar;
use Filament\Tables\Actions\DetachBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Phpsa\FilamentAuthentication\FilamentAuthentication;

class PermissionRelationManager extends RelationManager
{
    protected static string $relationship = 'permissions';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
            ->actions([
                DetachAction::make()
            ])

            ->bulkActions([

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
