<?php

namespace Phpsa\FilamentAuthentication\Subscribers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Events\Dispatcher;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Logout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Events\OtherDeviceLogout;
use Illuminate\Contracts\Auth\Authenticatable;
use Phpsa\FilamentAuthentication\Traits\LogsAuthentication;

class AuthenticationLoggingSubscriber
{
    public function __construct(public Request $request)
    {
    }


    public function subscribe(Dispatcher $events): array
    {
        return [
            Login::class             => 'handleUserLogin',
            Logout::class            => 'handleUserLogout',
            Failed::class            => 'handleUserFailedLogin',
            OtherDeviceLogout::class => 'handleOtherDeviceLogout',
        ];
    }

    protected function shouldLogAuthentication(Authenticatable $user): bool
    {
        return in_array(LogsAuthentication::class, class_uses_recursive(get_class($user)));
    }

    protected function logEvent(Authenticatable $user, bool $wasSuccessful, array $overrides = [])
    {
        if (! $this->shouldLogAuthentication($user)) {
            return;
        }

        return $user->authentications()->create([
            'ip_address'       => $this->request->ip(),
            'user_agent'       => $this->request->userAgent(),
            'login_at'         => now(),
            'login_successful' => $wasSuccessful,
    // @todo
     //       'location'         => config('filament-authentication.notifications.new-device.location') ? optional(geoip()->getLocation($ip))->toArray() : null,
            ... $overrides,
        ]);
    }

    public function handleUserLogin(Login $event): void
    {
        $user = $event->user;
        $log = $this->logEvent($user, true);

        // $newUser = Carbon::parse($user->{$user->getCreatedAtColumn()})->diffInMinutes(Carbon::now()) < 1;
        // if (! $known && ! $newUser && config('filament-authentication.notifications.new-device.enabled')) {
        //     $newDevice = config('filament-authentication.notifications.new-device.template') ?? NewDevice::class;
        //     $user->notify(new $newDevice($log));
        // }
    // if (LogsAuthentication) {
    // }
    }
    public function handleUserLogout(Logout $event)
    {
        $user = $event->user;
        if (! $this->shouldLogAuthentication($user)) {
            return;
        }

        $ip = $this->request->ip();
        $userAgent = $this->request->userAgent();
        $log = $user->authentications()
            ->whereIpAddress($ip)
            ->whereUserAgent($userAgent)
            ->whereNull('logout_at')
            ->firstOrNew([

                'ip_address' => $ip,
                'user_agent' => $userAgent,

            ]);
        $log->logout_at = now();

        $user->authentications()->save($log);
    }

    public function handleUserFailedLogin(Failed $event): void
    {
        $log = $this->logEvent($event->user, false);
        //todo: notify ?? with AuthRecord ?
        // if (config('filament-authentication.notifications.failed-login.enabled')) {
        //     $failedLogin = config('filament-authentication.notifications.failed-login.template') ?? FailedLogin::class;
        //     $event->user->notify(new $failedLogin($log));
        // }
    }

    public function handleOtherDeviceLogout(OtherDeviceLogout $event)
    {
        $user = $event->user;
        if (! $this->shouldLogAuthentication($user)) {
            return;
        }

        $ip = $this->request->ip();
        $userAgent = $this->request->userAgent();
        $log = $user->authentications()
            ->whereIpAddress($ip)
            ->whereUserAgent($userAgent)
            ->whereNull('logout_at')
            ->firstOrCreate([

                'ip_address' => $ip,
                'user_agent' => $userAgent,

            ]);

        $user->authentications()->whereLoginSuccessful(true)->whereNull('logout_at')
            ->whereKeyNot($log->getKey())->update([
                'logout_at'       => now(),
                'cleared_by_user' => true,
            ]);
    }
}
