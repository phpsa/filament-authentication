<?php
namespace Phpsa\FilamentAuthentication\Rules;

use Closure;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;
use Phpsa\FilamentAuthentication\Models\PasswordRenewLog;

class PreventPasswordReuseRule extends ValidationRule
{

    public function __construct(public Authenticatable $user)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //if config is disabled we don't wanna
        if ((int) config('filament-authentication.password_renew.prevent_password_reuse') <= 0) {
            return;
        }

        $previous = PasswordRenewLog::where('authenticatable_id', $this->user->getAuthIdentifier())
            ->where('authenticatable_type', get_class($this->user))
            ->latest()
            ->limit(config('filament-authentication.password_renew.prevent_password_reuse'))
            ->pluck('phash')
            ->filter(fn($hash) => Hash::check($value, $hash))
            ->isNotEmpty();

        if ($previous) {
            $fail('You cannot use the same password as a previous one.');
        }
    }
}
