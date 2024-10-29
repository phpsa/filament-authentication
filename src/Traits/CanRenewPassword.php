<?php

namespace Phpsa\FilamentAuthentication\Traits;

trait CanRenewPassword
{
    public function initializeCanRenewPassword()
    {
        static::saved(function (self $user) {

            $field = method_exists($user, 'getAuthPasswordName') ? $user->getAuthPasswordName() : 'password';

            if ($user->isDirty($field)) {
                $user->renewables()->where('created_at', now())->firstOrCreate([]);
            }
        });
    }

    public function renewables()
    {
        return $this->morphMany(config('filament-authentication.models.PasswordRenewLog'), 'renewable')->latest();
    }

    public function latestRenewable()
    {
        return $this->morphOne(config('filament-authentication.models.PasswordRenewLog'), 'renewable')->latestOfMany();
    }

    public function needsRenewal(): bool
    {
        $period = config('filament-authentication.password_renew.renew_password_days_period');

        if (! is_numeric($period) || $period <= 0) {
            return false;
        }

        return $this->latestRenewable()->where('created_at', '>=', now()->subDays($period))->doesntExist();
    }
}
