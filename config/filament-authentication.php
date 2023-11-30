<?php

return [
    'models'              => [
        'User'       => \App\Models\User::class,
        'Role'       => \Spatie\Permission\Models\Role::class,
        'Permission' => \Spatie\Permission\Models\Permission::class,
    ],
    'resources'           => [
        'UserResource'       => \Phpsa\FilamentAuthentication\Resources\UserResource::class,
        'RoleResource'       => \Phpsa\FilamentAuthentication\Resources\RoleResource::class,
        'PermissionResource' => \Phpsa\FilamentAuthentication\Resources\PermissionResource::class,
    ],
    'preload_roles'       => true,
    'preload_permissions' => true,
    'impersonate'         => [
        'enabled'  => true,
        'guard'    => 'web',
        'redirect' => '/'
    ],
    /**
     * Section Group
     */
    // 'section' => [
    //     'group' => 'Custom Group'
    // ]
];
