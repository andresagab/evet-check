<?php

/**
 * array with default permissions to store in db, also this permissions can be editable or removable
 */
return [
    # users
    [
        'name' => 'users',
        'display_name' => 'Módulo de usuarios',
        'description' => 'Permiso que permite acceder al módulo de usuarios',
        'module' => 'users',
    ],
    [
        'name' => 'users:add',
        'display_name' => 'Agregar un registro',
        'description' => 'Permiso que permite acceder a la función de agregar un registro',
        'module' => 'users',
    ],
    [
        'name' => 'users:edit',
        'display_name' => 'Editar un registro',
        'description' => 'Permiso que permite acceder a la función de editar un registro',
        'module' => 'users',
    ],
    [
        'name' => 'users:delete',
        'display_name' => 'Borrar un registro',
        'description' => 'Permiso que permite acceder a la función de agregar un registro',
        'module' => 'users',
    ],
    [
        'name' => 'users:manage-permissions',
        'display_name' => 'Gestionar permisos de usuario',
        'description' => 'Permiso que permite acceder a la función de gestionar permisos de un usuario',
        'module' => 'users',
    ],
    # permissions
    [
        'name' => 'permissions',
        'display_name' => 'Módulo de permisos',
        'description' => 'Permiso que permite acceder al módulo de permisos',
        'module' => 'permissions',
    ],
    [
        'name' => 'permissions:add',
        'display_name' => 'Agregar un registro',
        'description' => 'Permiso que permite acceder a la función de agregar un registro',
        'module' => 'permissions',
    ],
    [
        'name' => 'permissions:edit',
        'display_name' => 'Editar un registro',
        'description' => 'Permiso que permite acceder a la función de editar un registro',
        'module' => 'permissions',
    ],
    [
        'name' => 'permissions:delete',
        'display_name' => 'Borrar un registro',
        'description' => 'Permiso que permite acceder a la función de agregar un registro',
        'module' => 'permissions',
    ],
    # roles
    [
        'name' => 'roles',
        'display_name' => 'Módulo de roles',
        'description' => 'Permiso que permite acceder al módulo de roles',
        'module' => 'roles',
    ],
    [
        'name' => 'roles:add',
        'display_name' => 'Agregar un registro',
        'description' => 'Permiso que permite acceder a la función de agregar un registro',
        'module' => 'roles',
    ],
    [
        'name' => 'roles:edit',
        'display_name' => 'Editar un registro',
        'description' => 'Permiso que permite acceder a la función de editar un registro',
        'module' => 'roles',
    ],
    [
        'name' => 'roles:delete',
        'display_name' => 'Borrar un registro',
        'description' => 'Permiso que permite acceder a la función de agregar un registro',
        'module' => 'roles',
    ],
    [
        'name' => 'roles:manage-permissions',
        'display_name' => 'Gestionar permisos de rol',
        'description' => 'Permiso que permite acceder a la función de gestionar permisos de un rol',
        'module' => 'roles',
    ],

    # people
    [
        'name' => 'people',
        'display_name' => 'Módulo de Personas',
        'description' => 'Permiso que permite acceder al módulo de Personas',
        'module' => 'people',
    ],
    [
        'name' => 'people:add',
        'display_name' => 'Agregar un registro',
        'description' => 'Permiso que permite acceder a la función de agregar un registro',
        'module' => 'people',
    ],
    [
        'name' => 'people:edit',
        'display_name' => 'Editar un registro',
        'description' => 'Permiso que permite acceder a la función de editar un registro',
        'module' => 'people',
    ],
    [
        'name' => 'people:delete',
        'display_name' => 'Borrar un registro',
        'description' => 'Permiso que permite acceder a la función de agregar un registro',
        'module' => 'people',
    ],
    [
        'name' => 'people:manage-permissions',
        'display_name' => 'Gestionar permisos de rol',
        'description' => 'Permiso que permite acceder a la función de gestionar permisos de un rol',
        'module' => 'people',
    ],
    # event
    [
        'name' => 'events',
        'display_name' => 'Módulo de eventsos',
        'description' => 'Permiso que permite acceder al módulo de eventsos',
        'module' => 'events',
    ],
    [
        'name' => 'events:add',
        'display_name' => 'Agregar un registro',
        'description' => 'Permiso que permite acceder a la función de agregar un registro',
        'module' => 'events',
    ],
    [
        'name' => 'events:edit',
        'display_name' => 'Editar un registro',
        'description' => 'Permiso que permite acceder a la función de editar un registro',
        'module' => 'events',
    ],
    [
        'name' => 'events:delete',
        'display_name' => 'Borrar un registro',
        'description' => 'Permiso que permite acceder a la función de agregar un registro',
        'module' => 'events',
    ],
    [
        'name' => 'events:manage-activities',
        'display_name' => 'Gestionar actividades del eventso',
        'description' => 'Permiso que permite acceder al submodulo de actividades de un eventso',
        'module' => 'events',
    ],
];
