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

## Additional Resources:
### Spatie Roles & Permissions
If you have not yet configured this package it is automatically added by this installer, run the following steps:

1. You should publish the migration and the config/permission.php config file with:

```php
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

2. Add the `Spatie\Permission\Traits\HasRoles` trait to your Users model

3. Add Roles & Permissions as required

For more see: https://spatie.be/docs/laravel-permission/v5/introduction



### Laravel Impersonate
If you have not configured this package it is automatically added by this install, run the following steps:

1. Add the trait `Lab404\Impersonate\Models\Impersonate` to your User model.
2. Setup your permissions: https://github.com/404labfr/laravel-impersonate#defining-impersonation-authorization


## Security
Roles & Permissions can be secured using Laravel Policies,
create your policies and register then in the AuthServiceProvider

```php
 protected $policies = [
        Role::class       => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        CustomPage::class => CustomPagePolicy::class,
        SettingsPage::class => SettingsPagePolicy::class
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];
```

We have a Custom Page Trait: `Phpsa\FilamentAuthentication\Traits\PagePolicyTrait` and a Spatie Settings Page Trait `Phpsa\FilamentAuthentication\Traits\SettingsPage\PolicyTrait` that you can add to your pages / settings pages.
By defining a model and mapping it with a `viewAny($user)` method you can define per policies whether or not to show the page in navigation.

## Widgets
  `LatestUsersWidget` is by default published to your dashboard, this can be configured / disabled by editing the config in the filament-authentication config file:
  ```php
   'Widgets' => [
        'LatesetUsers' => [
            'enabled' => true,
            'limit' => 5,
        ],
    ],
```

Note that it is also attached to the UserPolicy::viewAny policy value if the policy exists

--It is planned to update the enabled to accept a callback function to allow for roles etc in the next version--

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


## Events

`Phpsa\FilamentAuthentication\Events\UserCreated`  is triggered when a user is created via the Resource

`Phpsa\FilamentAuthentication\Events\UserUpdated` is triggered when a user is updated via the Resource

## Intergration with other packages:
** Comming soon **

- https://filamentphp.com/plugins/socialite
- https://filamentphp.com/plugins/2fa

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Phpsa](https://github.com/phpsa)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
