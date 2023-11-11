<?php

namespace App\Models;

use Laratrust\Models\Role as RoleModel;
use Livewire\Wireable;

class Role extends RoleModel implements Wireable
{

    /// PROPERTIES

    public $guarded = [];

    /**
     * The fillable fields
     * @var string[]
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    /// PRIVATE FUNCTIONS

    /// RELATIONAL FUNCTIONS

    /// PUBLIC FUNCTIONS

    /// STATIC FUNCTIONS

    /**
     * Enable attributes for livewire
     * @return array
     */
    public function toLivewire()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'display_name' => $this->display_name,
            'description' => $this->description,
        ];
    }

    /**
     * Load attributes from livewire
     * @param $value
     * @return Role
     */
    public static function fromLivewire($value)
    {
        #return new static($value);
        $role = new Role;

        $role->id = $value['id'];
        $role->name = $value['name'];
        $role->display_name = $value['display_name'];
        $role->description = $value['description'];

        return $role;

    }


}
