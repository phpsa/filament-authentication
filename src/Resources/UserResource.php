<?php

namespace Phpsa\FilamentAuthentication\Resources;

use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Components\Section as Card;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Phpsa\FilamentAuthentication\FilamentAuthentication;
use Phpsa\FilamentAuthentication\Actions\ImpersonateLink;
use Phpsa\FilamentAuthentication\Traits\CanRenewPassword;
use Phpsa\FilamentAuthentication\Traits\LogsAuthentication;
use Phpsa\FilamentAuthentication\Resources\UserResource\Pages\EditUser;
use Phpsa\FilamentAuthentication\Resources\UserResource\Pages\ViewUser;
use Phpsa\FilamentAuthentication\Resources\UserResource\Pages\ListUsers;
use Phpsa\FilamentAuthentication\Resources\UserResource\Pages\CreateUser;
use Phpsa\FilamentAuthentication\Resources\UserResource\RelationManager\AuthenticationLogsRelationManager;

class UserResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $recordTitleAttribute = 'name';


    public static function getModel(): string
    {
        return FilamentAuthentication::getPlugin()->getModel('User');
    }

    public static function getNavigationGroup(): ?string
    {
        return strval(__(config('filament-authentication.section.group') ?? 'filament-authentication::filament-authentication.section.group'));
    }

    public static function getLabel(): string
    {
        return strval(__('filament-authentication::filament-authentication.section.user'));
    }

    public static function getPluralLabel(): string
    {
        return strval(__('filament-authentication::filament-authentication.section.users'));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return config('filament-authentication.navigation.user.register', true);
    }

    public static function getNavigationIcon(): string
    {
        return config('filament-authentication.navigation.user.icon');
    }

    public static function getNavigationSort(): ?int
    {
        return config('filament-authentication.navigation.user.sort');
    }
    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Card::make()
                    ->schema([
                        'name'                 => TextInput::make('name')
                            ->label(strval(__('filament-authentication::filament-authentication.field.user.name')))
                            ->required(),
                        'email'                => TextInput::make('email')
                            ->required()
                            ->email()
                            ->unique(table: static::$model, ignorable: fn ($record) => $record)
                            ->label(strval(__('filament-authentication::filament-authentication.field.user.email'))),
                        'password'             => TextInput::make('password')
                            ->same('passwordConfirmation')
                            ->hiddenOn('view')
                            ->live(debounce: 250)
                            ->password()
                            ->maxLength(255)
                            ->required(fn ($component, $get, $livewire, $model, $record, $set, $state) => $record === null)
                            ->dehydrateStateUsing(fn ($state) => ! empty($state) ? Hash::make($state) : '')
                            ->label(strval(__('filament-authentication::filament-authentication.field.user.password'))),
                        'passwordConfirmation' => TextInput::make('passwordConfirmation')
                            ->password()
                            ->dehydrated(false)
                            ->visible(fn(Get $get) => filled($get('password')))
                            ->maxLength(255)
                            ->label(strval(__('filament-authentication::filament-authentication.field.user.confirm_password'))),
                        'roles'                => Select::make('roles')
                            ->multiple()
                            ->relationship('roles', 'name')
                            ->preload(FilamentAuthentication::getPlugin()->getPreloadRoles())
                            ->label(strval(__('filament-authentication::filament-authentication.field.user.roles'))),
                    ])->columns(2),
            ]);
    }



    protected static function getTableColumns(): array
    {
        $columns = [
            'id'                => TextColumn::make('id')
                ->sortable()
                ->label(strval(__('filament-authentication::filament-authentication.field.id'))),
            'name'              => TextColumn::make('name')
                ->searchable()
                ->sortable()
                ->label(strval(__('filament-authentication::filament-authentication.field.user.name'))),
            'email'             => TextColumn::make('email')
                ->searchable()
                ->sortable()
                ->label(strval(__('filament-authentication::filament-authentication.field.user.email'))),

            'email_verified_at' => IconColumn::make('email_verified_at')
            ->default(false)
                ->boolean()
                ->label(strval(__('filament-authentication::filament-authentication.field.user.verified_at'))),
            'roles.name'        => TextColumn::make('roles.name')->badge()
                ->label(strval(__('filament-authentication::filament-authentication.field.user.roles'))),
            'created_at'        => TextColumn::make('created_at')
                ->dateTime('Y-m-d H:i:s')
                ->label(strval(__('filament-authentication::filament-authentication.field.user.created_at'))),
        ];

        if (in_array(LogsAuthentication::class, class_uses_recursive(FilamentAuthentication::getPlugin()->getModel('User')))) {
            $columns['last_login'] = TextColumn::make('latestSuccessfullAuthentication.login_at')
            ->dateTime('Y-m-d H:i:s')
            //@phpstan-ignore nullsafe.neverNull
            ->description(fn(Model $record) => $record->latestSuccessfullAuthentication?->ip_address ?? '-')
            ->label(strval(__('filament-authentication::filament-authentication.field.user.last_login_at')));
        }

        if (in_array(CanRenewPassword::class, class_uses_recursive(FilamentAuthentication::getPlugin()->getModel('User')))) {
            $columns['last_password_changed'] = TextColumn::make('latestRenewable.created_at')
            ->dateTime('Y-m-d H:i:s')
                       ->label(strval(__('filament-authentication::filament-authentication.field.user.last_password_updated')));
        }

        return $columns;
    }

    protected static function getTableFilters(): array
    {
        $filters =  [
            'email_verified_at' => TernaryFilter::make('email_verified_at')
                ->label(strval(__('filament-authentication::filament-authentication.filter.verified')))
                ->nullable(),
        ];

        if (FilamentAuthentication::getPlugin()->usesSoftDeletes()) {
            $filters['trashed'] = \Filament\Tables\Filters\TrashedFilter::make();
        }

        return $filters;
    }

    protected static function getTableActions(): array
    {
        $actions = [
            'view'         => ViewAction::make(),
            'edit'         => EditAction::make(),
            'impersonate'  => FilamentAuthentication::getPlugin()->impersonateEnabled() ? ImpersonateLink::make() : null,
            'delete'       => DeleteAction::make(),
            'force_delete' => FilamentAuthentication::getPlugin()->usesSoftDeletes() ? ForceDeleteAction::make() : null,
            'restore'      => FilamentAuthentication::getPlugin()->usesSoftDeletes() ? RestoreAction::make() : null,
        ];

        return array_filter($actions);
    }

    protected static function getTableBulkActions(): array
    {
        $actions = [
            DeleteBulkAction::make(),
            FilamentAuthentication::getPlugin()->usesSoftDeletes() ? RestoreBulkAction::make() : null,
            FilamentAuthentication::getPlugin()->usesSoftDeletes() ? ForceDeleteBulkAction::make() : null,
        ];

        return array_filter($actions);
    }


    public static function table(Table $table): Table
    {
        return $table
        ->columns(static::getTableColumns())
            ->filters(static::getTableFilters())
            ->actions(static::getTableActions())
            ->bulkActions(static::getTableBulkActions());
    }

    public static function getRelations(): array
    {
        return [
            AuthenticationLogsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit'   => EditUser::route('/{record}/edit'),
            'view'   => ViewUser::route('/{record}'),
        ];
    }


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->when(
                FilamentAuthentication::getPlugin()->usesSoftDeletes(),
                //@phpstan-ignore method.notFound (softDeletes)
                fn(Builder $builder) => $builder->withTrashed()
            );
    }
}
