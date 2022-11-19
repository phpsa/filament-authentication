<?php

namespace Phpsa\FilamentAuthentication\Resources\RoleResource\RelationManager;

use Filament\Resources\RelationManagers\BelongsToManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;

class UserRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $recordTitleAttribute = 'email';

    public static function table(Table $table): Table
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
                    ->label('Email'),

            ])
            ->filters([
                //
            ]);
    }

    public function afterAttach(): void
    {
    }

    public function afterDetach(): void
    {
    }
}
