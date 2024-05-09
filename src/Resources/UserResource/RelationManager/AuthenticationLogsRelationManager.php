<?php

namespace Phpsa\FilamentAuthentication\Resources\UserResource\RelationManager;

use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Facades\Filament;
use Illuminate\Support\HtmlString;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\RelationManagers\RelationManager;
use Phpsa\FilamentAuthentication\FilamentAuthentication;
use Phpsa\FilamentAuthentication\Traits\LogsAuthentication;

class AuthenticationLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'authentications';

    protected static ?string $recordTitleAttribute = 'id';


    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {

        if (in_array(LogsAuthentication::class, class_uses_recursive(FilamentAuthentication::getPlugin()->getModel('User')))) {
            return parent::canViewForRecord($ownerRecord, $pageClass);
        }
        return false;
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return trans('filament-authentication::filament-authentication.authentication-log.table.heading');
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->orderByDesc('login_at'))
            ->columns([
                TextColumn::make('authenticatable')
                    ->label(trans('filament-authentication::filament-authentication.authentication-log.column.authenticatable'))
                    ->formatStateUsing(function (?string $state, Model $record) {
                        if (! $record->authenticatable_id) {
                            return new HtmlString('&mdash;');
                        }

                        return new HtmlString('<a href="' . route('filament.' . Filament::getCurrentPanel()->getId() . '.resources.' . Str::plural((Str::lower(class_basename($record->authenticatable::class)))) . '.edit', ['record' => $record->authenticatable_id]) . '" class="inline-flex items-center justify-center hover:underline focus:outline-none focus:underline filament-tables-link text-primary-600 hover:text-primary-500 text-sm font-medium filament-tables-link-action">' . class_basename($record->authenticatable::class) . '</a>');
                    })
                    ->sortable(),
                TextColumn::make('ip_address')
                    ->label(trans('filament-authentication::filament-authentication.authentication-log.column.ip_address'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user_agent')
                    ->label(trans('filament-authentication::filament-authentication.authentication-log.column.user_agent'))
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }

                        return $state;
                    }),
                TextColumn::make('login_at')
                    ->label(trans('filament-authentication::filament-authentication.authentication-log.column.login_at'))
                    ->since()
                    ->sortable(),
                IconColumn::make('login_successful')
                    ->label(trans('filament-authentication::filament-authentication.authentication-log.column.login_successful'))
                    ->boolean()
                    ->sortable(),
                TextColumn::make('logout_at')
                    ->label(trans('filament-authentication::filament-authentication.authentication-log.column.logout_at'))
                    ->since()
                    ->sortable(),
                IconColumn::make('cleared_by_user')
                    ->label(trans('filament-authentication::filament-authentication.authentication-log.column.cleared_by_user'))
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }

    protected function canCreate(): bool
    {
        return false;
    }

    protected function canEdit(Model $record): bool
    {
        return false;
    }

    protected function canDelete(Model $record): bool
    {
        return false;
    }

    protected function canView(Model $record): bool
    {
        return $this->can('view', $record);
    }
}
