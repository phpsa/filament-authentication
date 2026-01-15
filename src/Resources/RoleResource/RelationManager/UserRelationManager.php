<?php

namespace Phpsa\FilamentAuthentication\Resources\RoleResource\RelationManager;

use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Resources\RelationManagers\RelationManager;

class UserRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $recordTitleAttribute = 'email';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(strval(__('filament-authentication::filament-authentication.field.id')))
                    ->searchable(),
                TextColumn::make('name')
                    ->label(strval(__('filament-authentication::filament-authentication.field.name')))
                    ->searchable(),
                TextColumn::make('email')
                ->searchable()
                ->label(strval(__('filament-authentication::filament-authentication.field.user.email'))),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                // ...
                AttachAction::make(),
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
    }

    public function afterDetach(): void
    {
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
