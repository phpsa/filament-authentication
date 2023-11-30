<?php

namespace Phpsa\FilamentAuthentication\Resources\RoleResource\RelationManager;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DissociateBulkAction;
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
            ->actions([
                DetachAction::make()
            ])

            ->bulkActions([

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
