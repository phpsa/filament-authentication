<?php

namespace Phpsa\FilamentAuthentication\Traits;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Gate;

/**
 * @phpstan-ignore trait.unused
 */
trait SettingsPagePolicyTrait
{
    public function mount(): void
    {
        abort_unless(static::canView(), 403);

        parent::mount();
    }

    protected static function canView(): bool
    {
        if (static::getPolicy() == null) {
            return false;
        }

        return static::getPolicy()->viewAny(Filament::auth()->user());
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return static::canView() && static::$shouldRegisterNavigation;
    }

    protected static function getPolicy()
    {
        return Gate::getPolicyFor(static::class);
    }
}
