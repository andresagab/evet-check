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

        'events' => 'Eventos',
        'event_attendances' => 'Asistencia de evento',
        'activities' => 'Actividades',
        'activity_attendances' => 'Asistencia de actividad',
        'people' => 'Personas',
        'locations' => 'Ubicaciones',

        'manage_account' => 'Gestionar cuenta',
        'profile' => 'Perfil',
        'logout' => 'Cerrar sesión',
    ],

    'content_page' => [
        'searcher' => 'Buscador',
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
            'confirm_delete' => 'Escribe "ELIMINAR" para confirmar la acción|ELIMINAR',
            'go_back' => 'Click para regresar a la página anterior',
            'yes' => 'Si',
            'not' => 'No',
        ]
    ],

    'errors' => [
        'record_not_loaded' => 'No fue posible cargar el registro, intentalo nuevamente',
        'try_error' => 'Error código: :code',
        'not_deleted' => 'No fue posible eliminar el registro, intentalo nuevamente',
        'not_saved' => 'No fue posible guardar el registro, intentalo nuevamente',
        'not_updated' => 'No fue posible actualizar el registro, intentalo nuevamente',
    ],

    'responses' => [
        'saved' => 'Datos guardados exitosamente',
            'updated' => 'Datos actualizados exitosamente',
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

        'statuses' => [
            'active' => 'Activo',
            'disabled' => 'Inhabilitado',
        ]

    ],

    'models' => [

        # ROLE MODEL ATTRIBUTES
        'role' => [
            'model_name' => 'Rol',
            'plural_model_name' => 'Roles',

            'name' => 'Nombre',
            'display_name' => 'Nombre en pantalla',
            'description' => 'Descripción',
            'inputs' => [
                'name' => 'Buscar por nombre de rol'
            ],
        ],

        # PERMISSION MODEL ATTRIBUTES
        'permission' => [
            'model_name' => 'Permiso',
            'plural_model_name' => 'Permisos',

            'name' => 'Nombre',
            'display_name' => 'Nombre en pantalla',
            'module' => 'Módulo',
            'description' => 'Descripción',
            'inputs' => [
                'name' => 'Buscar por nombre'
            ],
        ],

        # USER MODEL ATTRIBUTES
        'user' => [
            'model_name' => 'Usuario',

            'name' => 'Nombre',
            'code' => 'Código',
            'state' => 'Estado',
            'profile_photo' => 'Foto de perfil',

            'inputs' => [
                'name' => 'Buscar por nombre',
                'code' => 'Buscar por código',
            ],
        ],

        # PERSON MODEL ATTRIBUTES
        'person' => [
            'model_name' => 'Persona',

            'names' => 'Nombres',
            'surnames' => 'Apellidos',
            'nip' => 'N° identificación',
            'sex' => 'Sexo',
            'cel' => 'Celular',
            'phone' => 'Teléfono',
            'email' => 'Correo electrónico',
            'address' => 'Dirección',
            'type' => 'Tipo',
            'user' => 'Usuario',
            'contact' => 'Contacto',
            'names_surnames' => 'Nombres y apellidos',

            'filters' => [
                'person' => 'Buscar por nombres, apellidos o n° de identificación'
            ]

        ],

        # EVENT MODEL ATTRIBUTES
        'event' => [
            'model_name' => 'Evento',

            'name' => 'Nombre',
            'year' => 'Año',
            'banner_path' => 'Banner',
            'poster_path' => 'Poster',
            'virtual_card_path' => 'Carnet Virtual',
            'logo_path' => 'Logo',
            'state' => 'Estado',
            'symbolic_cost' => 'Costo simbólico',
            'certificate_path' => 'Plantilla de certificado',
            'certificate_setup' => 'Configuración de plantilla de certificado',
            'virtual_card_setup' => 'Configuración del carnet virtual',
            'min_percent' => 'Porcentaje mínimo',

            'registered_people' => 'Personas inscritas',
            'certificate_form' => 'Configurar certificado',
            'virtual_card_form' => 'Configurar carnet virtual',

            'filters' => [
                'name' => 'Buscar por nombre del evento',
                'year' => 'Buscar por año del evento',
            ],

            'states' => [
                'OP' => 'Abierto',
                'OG' => 'En curso',
                'CP' => 'Terminado',
            ],

            'bar_code_positions' => [
                'bottom' => 'Inferior',
                'top' => 'Superior',
                'custom' => 'Personalizado',
            ]

        ],

        # EVENT MODEL ATTRIBUTES
        'event_attendance' => [
            'model_name' => 'Asistencia de evento',

            'event' => 'Evento',
            'person' => 'Persona',
            'institution' => 'Institución',
            'other_institution' => 'Otra institución',
            'attendance' => 'Asistencia',
            'participation_modality' => 'Modalidad de participación',
            'type' => 'Tipo',
            'stay_type' => 'Tipo de asistencia',
            'payment_status' => 'Estado de pago',
            'approve_certificate_manually' => 'Aprobar el certificado manualmente',
            'certificate_info' => 'Certificado',
            'activities_info' => 'Actividades',
            'statuses' => 'Estados',

            'filters' => [
                'name' => 'Buscar por nombre del evento',
                'year' => 'Buscar por año del evento',
                'person' => 'Buscar por persona (nombres, apellidos o N° identificación)',
                'type' => 'Buscar por tipo de asistencia',
                'modality' => 'Buscar por modalidad de asistencia',
            ],

            'participation_modalities' => [
                'AS' => 'Asistente',
                'SP' => 'Ponente',
                'WS' => 'Tallerista',
                'LE' => 'Conferencista',
                'OR' => 'Organizador',
            ],
            'types' => [
                'SL' => 'Estudiante del Programa de Lic. en Informática de la Universidad de Nariño',
                'ST' => 'Estudiante',
                'TE' => 'Docente',
                'PT' => 'Particular',
                'EL' => 'Egresado del programa de Licenciatura en Informática',
            ],
            'stay_types' => [
                'P' => 'Presencial',
                'V' => 'Virtual',
            ],
            'payment_statuses' => [
                'NP' => 'Sin pagar',
                'NA' => 'No aplica',
                'PA' => 'Pagado',
            ],
            'certificate_statuses' => [
                'certified' => 'Certificado',
                'not_certified' => 'No certificado',
            ],
            'manually_certificate_statuses' => [
                'approved' => 'Aprobado manualmente',
                'not_approved' => 'No aprobado manualmente',
            ],

        ],

        # ACTIVITY MODEL ATTRIBUTES
        'activity' => [
            'model_name' => 'Actividad',

            'event' => 'Evento',
            'author_name' => 'Autor/es',
            'name' => 'Nombre',
            'slots' => 'Cupos',
            'free_slots' => 'Cupos libres',
            'type' => 'Tipo',
            'modality' => 'Modalidad',
            'status' => 'Estado',
            'hidden' => 'Oculto',
            'date' => 'Fecha',

            'filters' => [
                'author_name' => 'Buscar por autor de la actividad',
                'name' => 'Buscar por nombre de la actividad',
                'type' => 'Buscar por tipo de actividad',
                'status' => 'Buscar por estado de actividad',
                'date' => 'Buscar por fecha de actividad',
            ],

            'types' => [
                'CF' => 'Conferencia',
                'PT' => 'Ponencia',
                'CL' => 'Taller',
                'SN' => 'Refrigerio',
                'OT' => 'Otro',
            ],

            'modalities' => [
                'P' => 'Presencial',
                'V' => 'Virtual',
            ],

            'status_types' => [
                'O' => 'Abierta',
                'I' => 'En curso',
                'C' => 'Cerrada',
            ],

        ],

        # ACTIVITY ATTENDANCE MODEL ATTRIBUTES
        'activity_attendance' => [
            'model_name' => 'Asistencia de actividad',

            'activity' => 'Actividad',
            'person' => 'Persona',
            'state' => 'Estado',
            'attendance_date' => 'Fecha y hora de asistencia',
            'created_at' => 'Fecha y hora de inscripción',

            'filters' => [
                'person' => 'Buscar por nombres, apellidos o N° de identificación de la persona asistente',
                'state' => 'Buscar por estado',
                'attendance_date' => 'Buscar por fecha y hora de asistencia',
            ],

            'states' => [
                'SU' => 'Inscrito',
                'DO' => 'Realizado',
                'UR' => 'No realizado',
            ],

        ],

        # LOCATION MODEL ATTRIBUTES
        'location' => [
            'model_name' => 'Ubicación',

            'name' => 'Nombre',
            'address' => 'Dirección',
            'url' => 'URL',
            'is_maps_location' => '¿Es ubicación de Google Maps?',
            'active' => '¿Está activa?',

            'activities' => 'Actividades',

            'filters' => [
                'name' => 'Buscar por nombre de ubicación',
                'active' => 'Buscar por estado de ubicación',
            ],

        ],

    ]

];
