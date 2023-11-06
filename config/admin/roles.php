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
            'name' => 'assistant',
            'display_name' => 'Asistente',
            'description' => 'Role destinado para los usuarios asistentes',
        ],
        [
            'name' => 'organizer',
            'display_name' => 'Organizador',
            'description' => 'Role destinado para los usuarios organizadores',
        ],

    ]

];
