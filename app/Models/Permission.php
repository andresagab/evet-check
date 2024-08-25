<?php

namespace App\Models;

use App\Utils\CommonUtils;
use Illuminate\Support\Facades\Config;
use Laratrust\Models\Permission as PermissionModel;
use Livewire\Wireable;

class Permission extends PermissionModel implements Wireable
{
    public $guarded = [];

     /**
     * The fillable fields
     * @var string[]
     */
    protected $fillable = [
        'name',
        'display_name',
        'module',
        'description',
    ];

    ///const

    /**
     * The available modules of app
     */
    const MODULES = [
        # ADMIN
        'users' => [
            'translate_key' => 'messages.menu.users',
            'color' => 'green',
            'type' => 'admin',
        ],
        'permissions' => [
            'translate_key' => 'messages.menu.permissions',
            'color' => 'emerald',
            'type' => 'admin',
        ],
        'roles' => [
            'translate_key' => 'messages.menu.roles',
            'color' => 'lime',
            'type' => 'admin',
        ],
        # SYS
        'people' => [
            'translate_key' => 'messages.menu.people',
            'color' => 'violet',
            'type' => 'sys',
        ],
        'events' => [
            'translate_key' => 'messages.menu.events',
            'color' => 'blue',
            'type' => 'sys',
        ],
        'event_attendances' => [
            'translate_key' => 'messages.menu.event_attendances',
            'color' => 'orange',
            'type' => 'sys',
        ],
        'activities' => [
            'translate_key' => 'messages.menu.activities',
            'color' => 'red',
            'type' => 'sys',
        ],
        'activity_attendances' => [
            'translate_key' => 'messages.menu.activity_attendances',
            'color' => 'rose',
            'type' => 'sys',
        ],
        'locations' => [
            'translate_key' => 'messages.menu.locations',
            'color' => 'emerald',
            'type' => 'sys',
        ],
    ];

    /// private functions

    /// public functions

    public function toLivewire()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'display_name' => $this->display_name,
            'module' => $this->module,
            'description' => $this->description,
        ];
    }

     /**
     * Load attributes from livewire
     * @param $value
     * @return permission
     */
    public static function fromLivewire($value)
    {
        #return new static($value);
        $permission = new Permission();

        $permission->id = $value['id'];
        $permission->name = $value['name'];
        $permission->display_name = $value['display_name'];
        $permission->module = $value['module'];
        $permission->description = $value['description'];

        return $permission;

    }



    /**
     * get module reference value
     * @return array|null
     */
    public function get_module() : array|null
    {
        # define default value of module
        $module = null;
        # if module is not null
        if ($this->module)
            $module = CommonUtils::getKeyValueFromArray($this->module, self::MODULES);
        # return module value
        return $module;
    }

    /**
     * check if the permission is available to be editable or removable
     * @return bool
     */
    public function is_editable_or_removable() : bool
    {
        # define default response as true
        $is = true;
        # if current model object have id
        if ($this->id)
        {
            $keys = array_column(Config::get('admin.permissions') ?? [], 'name');
            $is = !in_array($this->name, $keys);
        }

        return $is;
    }

    /**
     * check if the permission it's used by a one or more users
     * @return bool => true if it's busy, false if not is
     */
    public function is_busy() : bool
    {
        # define default response as false
        $is = false;

        if ($this->id)
        {
            # count all users with current permission name
            $result = User::query()->whereHasPermission($this->name)->count();
            # set is with logical operation, true if $result is greater than 0, else if not
            $is = $result > 0;
        }

        return $is;
    }

    /**
     * get array of permissions grouped by modules
     * @return array|array[]
     */
    public static function get_permissions_by_module(): array
    {

        # load all permissions from DB
        $permissions = Permission::query()->orderBy('module', 'ASC')->orderBy('name')->orderBy('display_name')->get();
        # reuse MODULES const
        $modules = self::MODULES;
        # loop permissions
        foreach ($permissions as $permission) {
            # if isset $permission->module key in $modules
            if (array_key_exists($permission->module, $modules))
                $modules[$permission->module]['data'][] = $permission;
        }

        return $modules;
    }

    /// STATIC FUNCTIONS

}
