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
        'users' => 'Users',
        'permissions' => 'Permissions',
        'roles' => 'Roles',

        'events' => 'Events',
        'event_attendances' => 'Event attendances',
        'activities' => 'Activities',
        'people' => 'People',

        'manage_account' => 'Manage Account',
        'profile' => 'Profile',
        'logout' => 'Log Out',
    ],

    'content_page' => [
        'searcher' => 'Searcher',
    ],

    'data' => [
        'unregistered' => 'unregistered',
        'unknown' => 'unknown',
        'not_editable_removable' => 'This record cannot be edited or deleted because it is part of the system database',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
        'dates' => 'Dates',
        'actions' => [
            'add' => 'Add :resource',
            'edit' => 'Edit :resource',
            'delete' => 'Delete :resource',
            'confirm' => 'Confirm action',
            'delete_question' => '¿Are you sure to delete this record?',
            'irreversible' => 'This action is irreversible',
            'confirm_delete' => 'Type "DELETE" to confirm|DELETE',
            'go_back' => 'Click to go back',
        ]
    ],

    'errors' => [
        'record_not_loaded' => 'It was not possible to load the record, please try again',
        'try_error' => 'Error code: :code',
        'not_deleted' => 'It was not possible to delete the resource, please try again',
        'not_saved' => 'It was not possible to save the resource, please try again',
        'not_updated' => 'It was not possible to update the resource, please try again',
    ],

    'responses' => [
        'saved' => 'Data saved successfully',
        'updated' => 'Data udpated successfully',
        'deleted' => 'Resource deleted successfully',
    ],

    'collections' => [

        'sex_types' => [
            'male' => 'Male',
            'female' => 'Female',
        ],
        'people_types' => [
            'student' => 'Student',
            'main_coordinator' => 'Seed network coordinator',
            'group_coordinator' => 'Seed group coordinator',
            'other' => 'Other',
        ],

    ],

    'models' => [

        # ROLE MODEL ATTRIBUTES
        'role' => [
            'model_name' => 'Role',
            'plural_model_name' => 'Roles',

            'name' => 'Name',
            'display_name' => 'Display name',
            'description' => 'Description',
            'inputs' => [
                'name' => 'Search by role name'
            ],
        ],

        # PERMISSION MODEL ATTRIBUTES
        'permission' => [
            'model_name' => 'Permission',
            'plural_model_name' => 'Permissions',

            'name' => 'Name',
            'display_name' => 'Display name',
            'module' => 'Module',
            'description' => 'Description',
            'inputs' => [
                'name' => 'Search by permission name'
            ],
        ],

        # USER MODEL ATTRIBUTES
        'user' => [
            'model_name' => 'User',

            'name' => 'Name',
            'code' => 'Code',
            'state' => 'State',
            'profile_photo' => 'Profile photo',

            'inputs' => [
                'name' => 'Search by name',
                'code' => 'Search by code',
            ],
        ],

        # PERSON MODEL ATTRIBUTES
        'person' => [
            'model_name' => 'Person',
            'names' => 'Names',
            'surnames' => 'Surnames',
            'nip' => 'N° identification',
            'sex' => 'Sex',
            'cel' => 'Cell phone',
            'phone' => 'Phone',
            'email' => 'Email',
            'address' => 'Address',
            'type' => 'Type',
            'user' => 'User',
            'contact' => 'Contact',
            'names_surnames' => 'Names and surnames',

            'filters' => [
                'person' => 'Search by names, surnames or dni'
            ]

        ],

        # EVENT MODEL ATTRIBUTES
        'event' => [
            'model_name' => 'Event',

            'name' => 'Name',
            'year' => 'Year',
            'banner_path' => 'Banner',
            'poster_path' => 'Poster',

            'filters' => [
                'name' => 'Search by event name',
                'year' => 'Search by event year',
            ]

        ],


        # EVENT MODEL ATTRIBUTES
        'event_attendance' => [
            'model_name' => 'Event attendance',

            'event' => 'Event',

            'person' => 'Person',
            'institution' => 'Institution',
            'other_institution' => 'Other institution',
            'attendance' => 'Attendance',
            'participation_modality' => 'Participation modality',
            'type' => 'Type',
            'stay_type' => 'Stay type',

            'filters' => [
                'name' => 'Search by name of event',
                'year' => 'Search by year of event',
                'person' => 'Search by assistant of event (names, surnames or dni)',
                'participation_modality' => 'Search by participation modality',
                'type' => 'Search by type',
                'stay_type' => 'Search by stay type',
            ],

            'participation_modalities' => [
                'AS' => 'Assistant',
                'SP' => 'Speaker',
                'WS' => 'Educator',
            ],
            'types' => [
                'SL' => 'Student of Program of Lic. in Computing of the Universidad de Nariño',
                'ST' => 'Student',
                'TE' => 'Teacher',
                'PT' => 'Particular',
                'EL' => 'Graduate of Program of Lic. in Computing of the Universidad de Nariño',
            ],
            'stay_types' => [
                'P' => 'In person',
                'V' => 'Virtual',
            ],

        ],

    ],

];
