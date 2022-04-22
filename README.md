[![Latest Version on Packagist](https://img.shields.io/packagist/v/phpsa/filament-authentication.svg?style=flat-square)](https://packagist.org/packages/phpsa/filament-authentication)
[![Semantic Release](https://github.com/phpsa/filament-authentication/actions/workflows/release.yml/badge.svg)](https://github.com/phpsa/filament-authentication/actions/workflows/release.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/phpsa/filament-authentication.svg?style=flat-square)](https://packagist.org/packages/phpsa/filament-authentication)

# Filament User Authentication

User Resource For Filament Admin along with Roles & Permissions using Spatie

## Installation


You can install the package via composer:

```bash
composer require phpsa/filament-authentication
```

and now clear cache

```bash
php artisan optimize:clear
```

and publish config
```bash
php artisan vendor:publish --tag=filament-authentication-config
```

and optionally views / translations
```bash
artisan vendor:publish --tag=filament-authentication-views
artisan vendor:publish --tag=filament-authentication-translations
```

## Security
Roles & Permissions can be secured using Laravel Policies,
create your policies and register then in the AuthServiceProvider

```php
 protected $policies = [
        Role::class       => RolePolicy::class,
        Permission::class => PermissionPolicy::class
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];
```

## Widgets
adding  ` \Phpsa\FilamentAuthentication\Widgets\LatestUsersWidget::class` to the widgets in the filament.php config file will attach the LatestUsersWidget to your dashboard

## Profile
Profile view for currently authed user

## Extending
Extend Profile:
```php
<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Phpsa\FilamentAuthentication\Pages\Profile as PagesProfile;

class Profile extends PagesProfile
{}
```
or the view: `resources/views/vendor/filament-authentication/filament/pages/profile.blade.php` (you can publish existing one)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Phpsa](https://github.com/phpsa)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
