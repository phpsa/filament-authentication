[![Latest Version on Packagist](https://img.shields.io/packagist/v/phpsa/filament-authentication.svg?style=flat-square)](https://packagist.org/packages/phpsa/filament-authentication)
[![Semantic Release](https://github.com/phpsa/filament-authentication/actions/workflows/release.yml/badge.svg)](https://github.com/phpsa/filament-authentication/actions/workflows/release.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/phpsa/filament-authentication.svg?style=flat-square)](https://packagist.org/packages/phpsa/filament-authentication)

# Filament User Authentication

User Resource For Filament Admin along with Roles & Permissions using Spatie

## Package Installation


You can install the package via composer:

```bash
composer require phpsa/filament-authentication
```
and run the install command

```bash
php artisan filament-authentication::install
```
this will publish the config file and migrations


optionally publish views / translations
```bash
artisan vendor:publish --tag=filament-authentication-views
artisan vendor:publish --tag=filament-authentication-translations
```

### Spatie Roles & Permissions
If you have not yet configured this package it is automatically added by this installer, run the following steps:

1. You should publish the migration and the config/permission.php config file with:

```php
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

2. Add the `Spatie\Permission\Traits\HasRoles` trait to your Users model

3. Add Roles & Permissions as required

For more see: https://spatie.be/docs/laravel-permission/v6/introduction


## Setup & Config

in your Filament panel file you need to add the following to the Plugins section

add the resources
```php
 public function panel(Panel $panel): Panel
    {
        return $panel
            ...
            ->plugins([
                \Phpsa\FilamentAuthentication\FilamentAuthentication::make(),
            ])
            ...
```

You can configure this via either the config file or the plugin.


# Features
## 1. Widgets
  `LatestUsersWidget`  can be added to your dashboard by adding it to your panel widgets area..
```
 LatestUsersWidget::class
 ```

Note that it is also attached to the UserPolicy::viewAny policy value if the policy exists


## 2. Laravel Impersonate
If you have not configured this package it is automatically added by this install, run the following steps:

1. Add the trait `Lab404\Impersonate\Models\Impersonate` to your User model.
2. edit the config file and set impersonate->enabled to true

### Defining impersonation authorization

By default all users can **impersonate** an user.
You need to add the method `canImpersonate()` to your user model:

```php
    /**
     * @return bool
     */
    public function canImpersonate()
    {
        // For example
        return $this->is_admin == 1;
    }
```

By default all users can **be impersonated**.
You need to add the method `canBeImpersonated()` to your user model to extend this behavior:

```php
    /**
     * @return bool
     */
    public function canBeImpersonated()
    {
        // For example
        return $this->can_be_impersonated == 1;
    }
```

**Protect From Impersonation**

You can use the middleware `impersonate.protect` to protect your routes against user impersonation.
This middleware can be useful when you want to protect specific pages like users subscriptions, users credit cards, ...

```php
Router::get('/my-credit-card', function() {
    echo "Can't be accessed by an impersonator";
})->middleware('impersonate.protect');
```

**Events**
There are two events available that can be used to improve your workflow:
- `TakeImpersonation` is fired when an impersonation is taken.
- `LeaveImpersonation` is fired when an impersonation is leaved.

Each events returns two properties `$event->impersonator` and `$event->impersonated` containing User model instance.

## 3. Password Renewal

Introduced in V4.2.0 - this allows you to enforce a user to change their password every X days.

Enable this & configure this as Follows:
1. add the `Phpsa\FilamentAuthentication\Traits\CanRenewPassword` trait to your user model
2. configure the options for pruning and renewal day period in the config file
3. if not published, publish migration `artisan vendor:publish --tag filament-authentication-migrations`

this will force a user to update their password, note -- all existing users will initially be foreced to, this can be ignored by running the following command:

## Authentication Log

Introduced in V4.2.0 - this allows you to log each user login attempt.

Enable this & configure this as follows:
1. add the `Phpsa\FilamentAuthentication\Traits\LogsAuthentication`  trait to your user model
2. configure the options for prune in the authentication_log section of the config
3. optionally enable the resource in navigation section of the config file.
4. if not published, publish migration `artisan vendor:publish --tag filament-authentication-migrations`

this will now log login and logouts on the system.

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




## Events

`Phpsa\FilamentAuthentication\Events\UserCreated`  is triggered when a user is created via the Resource

`Phpsa\FilamentAuthentication\Events\UserUpdated` is triggered when a user is updated via the Resource

## Future Plans
* MFA Authentication
* Socialite Authentication
* Biometrics Athentication

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Phpsa](https://github.com/phpsa)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
