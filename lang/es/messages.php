<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'menu' => [
        'users' => 'Usuarios',
        'permissions' => 'Permisos',
        'roles' => 'Roles',

        'categories' => 'Categorias',
        'departments' => 'Departamentos',
        'people' => 'Personas',

        'manage_account' => 'Gestionar cuenta',
        'profile' => 'Perfil',
        'logout' => 'Cerrar sesión',
    ],

    'data' => [
        'unregistered' => 'No registra',
        'unknown' => 'Desconocido',
        'not_editable_removable' => 'Este registro no puede ser editado ni borrado porque hace parte de la base del sistema',
        'created_at' => 'Fecha de registro',
        'updated_at' => 'Fecha de última actualización',
        'dates' => 'Fechas',
        'actions' => [
            'add' => 'Agregar :resource',
            'edit' => 'Editar :resource',
            'delete' => 'Eliminar :resource',
            'confirm' => 'Confirmar acción',
            'delete_question' => '¿Está seguro de eliminar éste registro?',
            'irreversible' => 'Esta acción es irreversible',
        ]
    ],

    'errors' => [
        'record_not_loaded' => 'No fue posible cargar el registro, intentalo nuevamente',
        'try_error' => 'Error código: :code',
        'not_deleted' => 'No fue posible eliminar el registro, intentalo nuevamente',
    ],

    'responses' => [
        'saved' => 'Datos guardados exitosamente',
        'deleted' => 'Registro eliminado exitosamente',
    ],

    'collections' => [

        'sex_types' => [
            'male' => 'Masculino',
            'female' => 'Femenino',
        ],
        'people_types' => [
            'student' => 'Estudiante',
            'main_coordinator' => 'Coordinador de red de semilleros',
            'group_coordinator' => 'Coordinador de grupo semillero',
            'other' => 'Otro',
        ],

    ],

    'models' => [

        # ROLE MODEL ATTRIBUTES
        'role' => [
            'name' => 'Nombre',
            'display_name' => 'Nombre en pantalla',
            'description' => 'Descripción',
            'inputs' => [
                'name' => 'Buscar por nombre de rol'
            ],
        ],

        # USER MODEL ATTRIBUTES
        'user' => [
            'name' => 'Nombre',
            'code' => 'Código',
            'state' => 'Estado',
            'profile_photo' => 'Foto de perfil',
        ],

        # PERSON MODEL ATTRIBUTES
        'person' => [
            'person' => 'Persona',
            'names' => 'Nombres',
            'surnames' => 'Apellidos',
            'nip' => 'N° identificación',
            'sex' => 'Sexo',
            'cell_phone' => 'Celular',
            'phone' => 'Teléfono',
            'email' => 'Correo electrónico',
            'address' => 'Dirección',
            'type' => 'Tipo',
            'user' => 'Usuario',
            'contact' => 'Contacto',
            'names_surnames' => 'Nombres y apellidos',

            'filters' => [
                'person' => 'Buscar por nombres, apellidos, n° de identificación, nombre de usuario o código de usuario'
            ]

        ]

    ]

];
