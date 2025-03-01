<?php

namespace Phpsa\FilamentAuthentication\Pages\Auth;

use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Pages\SimplePage;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Yebor974\Filament\RenewPassword\RenewPasswordPlugin;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Phpsa\FilamentAuthentication\Rules\PreventPasswordReuseRule;
use Phpsa\FilamentAuthentication\Traits\CanRenewPassword;

/**
 *
 * @property Form $form
 * @package Phpsa\FilamentAuthentication\Pages\Auth
 */
class RenewPassword extends SimplePage
{
    use InteractsWithFormActions;

    /**
     * @var view-string
     * @phpstan-ignore property.defaultValue
     */
    protected static string $view = 'filament-authentication::pages.auth.renew-password';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $user = Filament::auth()->user();

        if (! in_array(CanRenewPassword::class, class_uses_recursive($user))
               || ! $user->needsRenewal() //@phpstan-ignore method.notFound (part of trait)
        ) {
            redirect()->intended(Filament::getUrl());
        }

        $this->form->fill();
    }

    public function renew()
    {
        /**
         * @var array{password: string, currentPassword: string} $data
         */
        $data = $this->form->getState();

        $user = Filament::auth()->user();

        $user->password = $data['password']; //@phpstan-ignore property.notFound
        $user->save();

        if (request()->hasSession()) {
            request()->session()->put([
                'password_hash_' . Filament::getAuthGuard() => $user->password,
            ]);
        }

        Notification::make()
            ->title(__('filament-authentication::filament-authentication.renew_notifications.title'))
            ->body(__('filament-authentication::filament-authentication.renew_notifications.body'))
            ->success()
            ->send();

        return redirect()->intended(Filament::getUrl());
    }

    public function form(Form $form): Form
    {
        return $form;
    }

    /**
     * @return array<int | string, string | Form>
     */
    protected function getForms(): array
    {

        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        TextInput::make('currentPassword')
                            ->label(__('filament-authentication::filament-authentication.field.user.current_password'))
                            ->password()
                            ->required()
                            ->rule('current_password:' . filament()->getAuthGuard()),
                        TextInput::make('password')
                            ->label(__('filament-authentication::filament-authentication.field.user.password'))
                            ->password()
                            ->revealable(filament()->arePasswordsRevealable())
                            ->required()
                            ->rules(['different:data.currentPassword', PasswordRule::default(), new PreventPasswordReuseRule()]),
                        TextInput::make('PasswordConfirmation')
                            ->label(__('filament-authentication::filament-authentication.field.user.confirm_password'))
                            ->password()
                            ->revealable(filament()->arePasswordsRevealable())
                            ->required()
                            ->same('password'),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function hasFullWidthFormActions(): bool
    {
        return true;
    }

    protected function getFormActions(): array
    {
        return [
            $this->getRenewFormAction(),
        ];
    }

    protected function getRenewFormAction(): Action
    {

        return Action::make('renew')
            ->label(__('filament-authentication::filament-authentication.form.actions.renew.label'))
            ->submit('renew');
    }

    public function getTitle(): string | Htmlable
    {
        return __('filament-authentication::filament-authentication.renew_page_title');
    }

    public function getHeading(): string | Htmlable
    {
        return __('filament-authentication::filament-authentication.renew_page_heading');
    }
}
