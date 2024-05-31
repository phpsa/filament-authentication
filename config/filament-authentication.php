<?php

return [
    'models'              => [
        'User'              => \App\Models\User::class,
        'Role'              => \Spatie\Permission\Models\Role::class,
        'Permission'        => \Spatie\Permission\Models\Permission::class,
        'AuthenticationLog' => \Phpsa\FilamentAuthentication\Models\AuthenticationLog::class,
        'PasswordRenewLog'  => \Phpsa\FilamentAuthentication\Models\PasswordRenewLog::class,
    ],
    'resources'           => [
        'UserResource'              => \Phpsa\FilamentAuthentication\Resources\UserResource::class,
        'RoleResource'              => \Phpsa\FilamentAuthentication\Resources\RoleResource::class,
        'PermissionResource'        => \Phpsa\FilamentAuthentication\Resources\PermissionResource::class,
        'AuthenticationLogResource' => \Phpsa\FilamentAuthentication\Resources\AuthenticationLogResource::class,
    ],
    'navigation'          => [
        'user'               => [
            'register' => true,
            'sort'     => 1,
            'icon'     => 'heroicon-o-user'
        ],
        'role'               => [
            'register' => true,
            'sort'     => 3,
            'icon'     => 'heroicon-o-user-group'
        ],
        'permission'         => [
            'register' => true,
            'sort'     => 4,
            'icon'     => 'heroicon-o-lock-closed'
        ],
        'authentication_log' => [
            'register' => false,
            'sort'     => 2,
            'icon'     => 'heroicon-o-shield-check'
        ],
    ],
    'preload_roles'       => true,
    'preload_permissions' => true,
    'impersonate'         => [
        'enabled'  => false,
        'guard'    => 'web',
        'redirect' => '/'
    ],
    'soft_deletes'        => false,
    'authentication_log'  => [
        'table_name'    => 'authentication_log',
        //The database connection where the authentication_log table resides. Leave empty to use the default
        'db_connection' => null,
        //The number of days to keep the authentication logs for. Set to 0 to keep forever
        // remeber to schedule
        //Schedule::command('model:prune')->daily();
        'prune'         => 365,
    ],
    'password_renew'      => [
        'table_name'                 => 'password_renew_log',
        //The database connection where the password_logs table resides. Leave empty to use the default
        'db_connection'              => null,
        //The number of days to keep the password logs for. Set to 0 to keep forever
        // remeber to schedule
        //Schedule::command('model:prune')->daily();
        'prune'                      => 365,
        //renew password days period, 0 to disable
        'renew_password_days_period' => 90,
        //prevent password reuse for x times, 0 to disable
        'prevent_password_reuse'     => 0,
    ],


];
