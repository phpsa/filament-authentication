<?php

namespace Phpsa\FilamentAuthentication\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property string $authenticatable_type
 * @property int $authenticatable_id
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property \Illuminate\Support\Carbon|null $login_at
 * @property bool $login_successful
 * @property \Illuminate\Support\Carbon|null $logout_at
 * @property bool $cleared_by_user
 * @property array|null $location
 */
class PasswordRenewLog extends Model
{
    use Prunable;

    //no guarding
    protected $guarded = [];

    public function getConnectionName()
    {
        return config('filament-authentication.password_renew.db_connection', null) ?? $this->connection;
    }

    public function getTable()
    {
        return config('filament-authentication.password_renew.table_name', 'authentication_log');
    }

    public function authenticatable(): MorphTo
    {
        return $this->morphTo();
    }

    public function prunable(): Builder
    {
        $days = config('filament-authentication.password_renew.prune', 365);
        if ((int) $days <= 0) {
            // If the value is 0 or less, we don't want to prune anything.
            return static::whereNull('id');
        }
        return static::where('created_at', '<=', now()->subDays(365));
    }
}
