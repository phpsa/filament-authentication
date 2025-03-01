<?php

namespace Phpsa\FilamentAuthentication\Traits;

/**
 * @phpstan-ignore trait.unused
 */
trait LogsAuthentication
{
    public function authentications()
    {
        return $this->morphMany(config('filament-authentication.models.AuthenticationLog'), 'authenticatable')->latest('login_at');
    }

    public function latestAuthentication()
    {
        return $this->morphOne(config('filament-authentication.models.AuthenticationLog'), 'authenticatable')->latestOfMany('login_at');
    }

    public function latestSuccessfullAuthentication()
    {
        return $this->latestAuthentication()->whereLoginSuccessful(true);
    }

    public function lastLoginAt()
    {
        return $this->authentications()->first()?->login_at;
    }

    public function lastSuccessfulLoginAt()
    {
        return $this->authentications()->whereLoginSuccessful(true)->first()?->login_at;
    }

    public function lastLoginIp()
    {
        return $this->authentications()->first()?->ip_address;
    }

    public function lastSuccessfulLoginIp()
    {
        return $this->authentications()->whereLoginSuccessful(true)->first()?->ip_address;
    }

    public function previousLoginAt()
    {
        return $this->authentications()->skip(1)->first()?->login_at;
    }

    public function previousLoginIp()
    {
        return $this->authentications()->skip(1)->first()?->ip_address;
    }
}
