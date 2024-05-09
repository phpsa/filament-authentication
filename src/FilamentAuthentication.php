<?php

namespace Phpsa\FilamentAuthentication;

use Closure;
use Filament\Panel;
use Illuminate\Support\Arr;
use Filament\Contracts\Plugin;
use Filament\Tables\Columns\TextColumn;
use Phpsa\FilamentAuthentication\Http\Middleware\ImpersonatingMiddleware;
use Phpsa\FilamentAuthentication\Http\Middleware\RenewPasswordMiddleware;

class FilamentAuthentication implements Plugin
{
    protected bool $preloadRoles = true;
    protected bool $preloadPermissions = true;
    protected bool $impersonate = false;
    protected string $impersonateGuard = 'web';
    protected string|Closure $impersonateRedirect = '/';
    protected bool $softDeletes = false;

    /**
     * @var array<string, class-string>
     */
    protected array $models              = [];

    /**
     * @var array<string, class-string>
     */
    protected array $resources =  [];

    public static function make(): self
    {
        $instance = new static();
        $config = config('filament-authentication');
        $instance->overrideModels($config['models']);
        $instance->overrideResources($config['resources']);
        $instance->setPreload($config['preload_roles'], $config['preload_permissions']);
        $instance->setImpersonation($config['impersonate']['enabled'], $config['impersonate']['guard'], $config['impersonate']['redirect']);
        $instance->withSoftDeletes($config['soft_deletes']);

        return $instance;
    }

    public static function getPlugin(): self
    {
        return filament('filament-authentication');
    }

    public function getId(): string
    {
        return 'filament-authentication';
    }

    public function register(Panel $panel): void
    {
        $panel->resources($this->resources);
        $panel->middleware([ImpersonatingMiddleware::class, RenewPasswordMiddleware::class]);
    }

    public function boot(Panel $panel): void
    {
        TextColumn::macro('humanDate', function () {
            /** @var \Filament\Tables\Columns\TextColumn&\Filament\Tables\Columns\Concerns\CanFormatState $this */
            $this->formatStateUsing(fn ($state): ?string => $state ? $state->diffForHumans() : null);

            return $this;
        });
    }

    public function setPreload(bool $roles = true, bool $permissions = true): self
    {
        $this->preloadRoles = $roles;
        $this->preloadPermissions = $permissions;

        return $this;
    }

    public function getPreloadRoles(): bool
    {
        return $this->preloadRoles;
    }

    public function getPreloadPermissions(): bool
    {
        return $this->preloadPermissions;
    }

    public function setImpersonation(bool $enabled = true, string $guard = 'web', string|Closure $redirect = '/'): self
    {
        $this->impersonate = $enabled;
        $this->impersonateGuard = $guard;
        $this->impersonateRedirect = $redirect;

        return $this;
    }

    public function impersonateEnabled(): bool
    {
        return $this->impersonate;
    }

    public function getImpersonateGuard(): string
    {
        return $this->impersonateGuard;
    }

    public function getImpersonateRedirect(): string|Closure
    {
        $value = $this->impersonateRedirect;
        if (! $value instanceof Closure) {
            return $value;
        }
        return $value();
    }

    /**
     * @param array<string,class-string> $overrides
     */
    public function overrideModels(array $overrides): self
    {
        $this->models = array_merge($this->models, $overrides);
        return $this;
    }

    public function getModel(string $model): string
    {
        return $this->models[$model];
    }

        /**
     * @param array<string,class-string|null> $overrides
     */
    public function overrideResources(array $overrides): self
    {
        $resources = array_merge($this->resources, $overrides);
        $this->resources = Arr::whereNotNull($resources);
        return $this;
    }

    public function getResource(string $resource): string
    {
        return $this->resources[$resource];
    }

    public function withSoftDeletes(bool $enabled = true): self
    {
        $this->softDeletes = $enabled;
        return $this;
    }

    public function usesSoftDeletes(): bool
    {
        return $this->softDeletes;
    }
}
