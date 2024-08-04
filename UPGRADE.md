# Upgrading V4 - V5

Breaking Changes:
- Impersonation - links now generated based on panels, so route name and path will be slightly different
- Password Renew - added phash to the table to store previous passwords, this will be used to validate if a password has been used before.



Upgrading V2 - V3

- Widget / panels no longer auto-published
- Profile screen removed in favour of Filaments default one

Breaking Change V1 - V2
*****

-- no longer customises the DateTime values in the user tables, makes use of Filament core verson.

in your AppServiceProvider add the following to the boot method:
```php
    DateTimePicker::configureUsing(fn (DateTimePicker $component) => $component->timezone(config('app.user_timezone')));
    TextColumn::configureUsing(fn (TextColumn $column) => $column->timezone(config('app.user_timezone')));
```
