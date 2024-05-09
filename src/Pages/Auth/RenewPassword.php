<?php

namespace Phpsa\FilamentAuthentication\Pages\Auth;

use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Pages\SimplePage;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Yebor974\Filament\RenewPassword\RenewPasswordPlugin;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Phpsa\FilamentAuthentication\Traits\CanRenewPassword;

class RenewPassword extends SimplePage
{
    use InteractsWithFormActions;

    /**
     * @var view-string
     */
    protected static string $view = 'filament-authentication::pages.auth.renew-password';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $user = Filament::auth()->user();

        if (
               ! in_array(CanRenewPassword::class, class_uses_recursive($user))
               || ! $user->needsRenewal()
        ) {
            redirect()->intended(Filament::getUrl());
        }

        $this->form->fill();
    }

    public function renew()
    {
        $data = $this->form->getState();

        $user = Filament::auth()->user();

        $user->password = $data['password'];
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
                            ->rules(['different:data.currentPassword', PasswordRule::default()]),
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
