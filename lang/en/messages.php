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

        'categories' => 'Categories',
        'departments' => 'Departments',
        'people' => 'People',

        'manage_account' => 'Manage Account',
        'profile' => 'Profile',
        'logout' => 'Log Out',
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
            'name' => 'Name',
            'display_name' => 'Display name',
            'description' => 'Description',
            'inputs' => [
                'name' => 'Search by role name'
            ],
        ],

        # USER MODEL ATTRIBUTES
        'user' => [
            'name' => 'Name',
            'code' => 'Code',
            'state' => 'State',
            'profile_photo' => 'Profile photo',
        ],

        # PERSON MODEL ATTRIBUTES
        'person' => [
            'person' => 'Person',
            'names' => 'Names',
            'surnames' => 'Surnames',
            'nip' => 'N° identification',
            'sex' => 'Sex',
            'cell_phone' => 'Cell phone',
            'phone' => 'Phone',
            'email' => 'Email',
            'address' => 'Address',
            'type' => 'Type',
            'user' => 'User',
            'contact' => 'Contact',
            'names_surnames' => 'Names and surnames',

            'filters' => [
                'person' => 'Search by names, surnames, dni, username or user code'
            ]

        ]

    ],

];
