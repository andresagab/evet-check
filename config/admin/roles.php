<?php

/**
 * Array with default data or configuration of roles
 */
return [

    /**
     * array with default roles to store in db, also this roles cannot be editable or removable
     */
    'roles' => [

        [
            'name' => 'super-user',
            'display_name' => 'Super usuario',
            'description' => 'Role que permite acceder al panel de administración de roles y permisos del software',
        ],
        [
            'name' => 'main-coordinator',
            'display_name' => 'Coordinador de red',
            'description' => 'Role destinado para los usuarios coordinadores de red',
        ],
        [
            'name' => 'group-coordinator',
            'display_name' => 'Coordinador de grupo',
            'description' => 'Role destinado para los usuarios coordinadores de grupo',
        ],

    ]

];
