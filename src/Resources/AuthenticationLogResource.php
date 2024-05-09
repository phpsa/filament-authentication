<?php

namespace Phpsa\FilamentAuthentication\Resources;

use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Phpsa\FilamentAuthentication\FilamentAuthentication;
use Phpsa\FilamentAuthentication\Resources\AuthenticationLogResource\Pages\ListAuthenticationLogs;

class AuthenticationLogResource extends Resource
{
    public static function getModel(): string
    {
        return FilamentAuthentication::getPlugin()->getModel('AuthenticationLog');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return config('filament-authentication.navigation.authentication_log.register', true);
    }

    public static function getNavigationIcon(): string
    {
        return config('filament-authentication.navigation.authentication_log.icon');
    }

    public static function getNavigationSort(): ?int
    {
        return config('filament-authentication.navigation.authentication_log.sort');
    }

    public static function getNavigationGroup(): ?string
    {
        return strval(__(config('filament-authentication.section.group') ?? 'filament-authentication::filament-authentication.section.group'));
    }

    public static function getLabel(): string
    {
        return __('filament-authentication::filament-authentication.section.authentication_log.label');
    }

    public static function getPluralLabel(): string
    {
        return __('filament-authentication::filament-authentication.section.authentication_log.plural-label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\MorphToSelect::make('authenticable')
                //     ->types(self::authenticableResources())
                //     ->required(),
                // Forms\Components\TextInput::make('Ip Address'),
                // Forms\Components\TextInput::make('User Agent'),
                // Forms\Components\DateTimePicker::make('Login At'),
                // Forms\Components\Toggle::make('Login Successful'),
                // Forms\Components\DateTimePicker::make('Logout At'),
                // Forms\Components\Toggle::make('Cleared By User'),
                // Forms\Components\KeyValue::make('Location'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('authenticatable')
                    ->label(trans('filament-authentication::filament-authentication.authentication-log.column.authenticatable'))
                    ->formatStateUsing(function (?string $state, Model $record) {
                        if (! $record->authenticatable_id) {
                            return new HtmlString('&mdash;');
                        }

                        return new HtmlString('<a href="' . route('filament.' . Filament::getCurrentPanel()->getId() . '.resources.' . Str::plural((Str::lower(class_basename($record->authenticatable::class)))) . '.edit', ['record' => $record->authenticatable_id]) . '" class="inline-flex items-center justify-center hover:underline focus:outline-none focus:underline filament-tables-link text-primary-600 hover:text-primary-500 text-sm font-medium filament-tables-link-action">' . class_basename($record->authenticatable::class) . '</a>');
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label(trans('filament-authentication::filament-authentication.authentication-log.column.ip_address'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_agent')
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
                Tables\Columns\TextColumn::make('login_at')
                    ->label(trans('filament-authentication::filament-authentication.authentication-log.column.login_at'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('login_successful')
                    ->label(trans('filament-authentication::filament-authentication.authentication-log.column.login_successful'))
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('logout_at')
                    ->label(trans('filament-authentication::filament-authentication.authentication-log.column.logout_at'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('cleared_by_user')
                    ->label(trans('filament-authentication::filament-authentication.authentication-log.column.cleared_by_user'))
                    ->boolean()
                    ->sortable(),
                //Tables\Columns\TextColumn::make('location'),
            ])
            ->actions([
                //
            ])
            ->filters([
                Filter::make('login_successful')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('login_successful', true)),
                Filter::make('login_at')
                    ->form([
                        DatePicker::make('login_from'),
                        DatePicker::make('login_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['login_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('login_at', '>=', $date),
                            )
                            ->when(
                                $data['login_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('login_at', '<=', $date),
                            );
                    }),
                Filter::make('cleared_by_user')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('cleared_by_user', true)),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAuthenticationLogs::route('/'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            //
        ];
    }

    // public static function authenticableResources(): array
    // {
    //     return config('filament-authentication.authenticable-resources', [
    //         \App\Models\User::class,
    //     ]);
    // }
}
