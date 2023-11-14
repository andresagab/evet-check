<?php

namespace App\Models;

use Illuminate\Support\Facades\Config;
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


    /**
     * Check if current model is editable or removable
     * @return bool
     */
    public function is_editable_or_removable() : bool
    {
        # define $is as true
        $is = true;

        # if current model resource have id
        if ($this->id)
        {
            # get array with names of main roles
            $keys = array_column(Config::get('admin.roles.roles'), 'name');
            # set is with in_array function result
            $is = !in_array($this->name, $keys);
        }

        return $is;
    }

    /**
     * check if the permission it's used by a one or more users
     * @return bool
     */
    public function isBusy() : bool
    {
        # define default response value
        $is = false;

        # if current model object have id
        if ($this->id)
        {
            # count all users with current role name
            $result = User::query()->whereHasRole($this->name)->count();
            # set is with logical operation, true if $result is greater than 0, else if not
            $is = $result > 0;
        }

        return $is;
    }

    /// STATIC FUNCTIONS

}
