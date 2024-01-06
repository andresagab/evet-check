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
    # events
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
        'display_name' => 'Gestionar actividades del evento',
        'description' => 'Permiso que permite acceder al submodulo de actividades de un eventso',
        'module' => 'events',
    ],
    [
        'name' => 'events:setup-certificate',
        'display_name' => 'Configurar certificado del evento',
        'description' => 'Permiso que permite acceder a la configuración del certificado de un evento',
        'module' => 'events',
    ],
    [
        'name' => 'events:setup-virtual-card',
        'display_name' => 'Configurar carnet virtual del evento',
        'description' => 'Permiso que permite acceder a la configuración del carnet virtual de un evento',
        'module' => 'events',
    ],
    # event attendances
    [
        'name' => 'event_attendances',
        'display_name' => 'Módulo de asistencia de evento',
        'description' => 'Permiso que permite acceder al módulo de asistencia de evento',
        'module' => 'event_attendances',
    ],
    [
        'name' => 'event_attendances:add',
        'display_name' => 'Agregar un registro',
        'description' => 'Permiso que permite acceder a la función de agregar un registro',
        'module' => 'event_attendances',
    ],
    [
        'name' => 'event_attendances:edit',
        'display_name' => 'Editar un registro',
        'description' => 'Permiso que permite acceder a la función de editar un registro',
        'module' => 'event_attendances',
    ],
    [
        'name' => 'event_attendances:delete',
        'display_name' => 'Borrar un registro',
        'description' => 'Permiso que permite acceder a la función de agregar un registro',
        'module' => 'event_attendances',
    ],
    [
        'name' => 'event_attendances:set_as_paid',
        'display_name' => 'Registrar como pagado',
        'description' => 'Permiso que permite acceder a la función de "registrar como pagado"',
        'module' => 'event_attendances',
    ],
    [
        'name' => 'event_attendances:set_approve_certificate_manually',
        'display_name' => 'Aprobar certificado manualmente',
        'description' => 'Permiso que permite acceder a la función de "Aprobar certificado manualmente"',
        'module' => 'event_attendances',
    ],
    # activities
    [
        'name' => 'activities',
        'display_name' => 'Módulo de actividades',
        'description' => 'Permiso que permite acceder al módulo de actividades',
        'module' => 'activities',
    ],
    [
        'name' => 'activities:add',
        'display_name' => 'Agregar un registro',
        'description' => 'Permiso que permite acceder a la función de agregar un registro',
        'module' => 'activities',
    ],
    [
        'name' => 'activities:edit',
        'display_name' => 'Editar un registro',
        'description' => 'Permiso que permite acceder a la función de editar un registro',
        'module' => 'activities',
    ],
    [
        'name' => 'activities:delete',
        'display_name' => 'Borrar un registro',
        'description' => 'Permiso que permite acceder a la función de agregar un registro',
        'module' => 'activities',
    ],
    [
        'name' => 'activities:register-attendance',
        'display_name' => 'Registrar asistencia',
        'description' => 'Permiso que permite acceder a la función de registrar la asistencia a una actividad',
        'module' => 'activities',
    ],
    # activity_attendances
    [
        'name' => 'activity_attendances',
        'display_name' => 'Módulo de asistencia de actividad',
        'description' => 'Permiso que permite acceder al módulo de asistencia de actividad',
        'module' => 'activity_attendances',
    ],
    [
        'name' => 'activity_attendances:add',
        'display_name' => 'Agregar un registro',
        'description' => 'Permiso que permite acceder a la función de agregar un registro',
        'module' => 'activity_attendances',
    ],
    [
        'name' => 'activity_attendances:edit',
        'display_name' => 'Editar un registro',
        'description' => 'Permiso que permite acceder a la función de editar un registro',
        'module' => 'activity_attendances',
    ],
    [
        'name' => 'activity_attendances:delete',
        'display_name' => 'Borrar un registro',
        'description' => 'Permiso que permite acceder a la función de agregar un registro',
        'module' => 'activity_attendances',
    ],
];
