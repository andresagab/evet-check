<?php

namespace App\Livewire\Forms\Admin\Permissions;

use App\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Rule;
use Livewire\Form;

class Frm extends Form
{
     /// PROPERTIES

    /**
     * Model of main resource
     * @var permission|null
     */
    public ?Permission $permission;

    /**
     * The name attribute
     * @prop string
     */
    public $name = '';

    /**
     * The display_name attribute
     * @prop string
     */
    public $display_name = '';

    /**
     * The module attribute
     * @prop string
     */
    public $module = '';

    /**
     * The description attribute
     * @prop string
     */
    public $description = '';

    /// PUBLIC FUNCTIONS

    /**
     * Define rules of form
     * @return array|array[]
     */
    public function rules()
    {
        # define rules
        $rules = [
            'name' => [
                'required',
                'string',
                'max:250',
            ],
            'display_name' => [
                'required',
                'string',
                'max:250',
            ],

            'module' => [
                'required',
                'string',
                'max:250',
            ],
            
            'description' => [
                'nullable',
                'string',
                'max:250',
            ],
        ];

        # if not empty $this->permission, then create custom validation to update a resource
        if (!empty($this->permission))
        {
            $rules['name'][] = "unique:permissions,name,{$this->permission->id}";
        }
        # else, then create custom validation for create new resource
        else
        {
            $rules['name'][] = 'unique:permissions,name';
        }

        return $rules;

    }

    /**
     * Set attributes and model resource of form
     * @param permission $permission
     * @return void
     */
    public function set_permission(Permission $permission) : void
    {
        # set permission
        $this->permission = $permission;
        # set form attributes
        $this->name = $permission->name;
        $this->display_name = $permission->display_name;
        $this->module = $permission->module;
        $this->description = $permission->description;
    }

    /**
     * Store data
     * @return string
     */
    public function store() : string
    {
        
        # validate fields
        $this->validate();

        # define state of action: 1 => saved, 2 => not_saved, 3 => try_error
        $message = __('messages.responses.saved');

        # use try
        try {
            # store data
            Permission::create($this->only(['name', 'display_name', 'module','description']));

        }
        catch (\Exception $e)
        {
            # dispatch toast
            $message = __('messages.errors.try_error', ['code' => $e->getCode()]);
            # log error
            error_log("Error => " . $e->getMessage());
        }

        # reset form
        $this->reset();

        # return true
        return $message;
    }

    /**
     * Update data
     * @return string
     */
    public function update() : string
    {

        # validate fields
        $this->validate();

        # define state of action: 1 => saved, 2 => not_saved, 3 => try_error
        $message = __('messages.responses.updated');
        # use try
        try {

            # search resource
            $permission = Permission::query()->find($this->permission->id);

            # update data
            if (!$permission->update($this->all()))
                $message = __('messages.errors.not_updated');

        }
        catch (\Exception $e)
        {
            # dispatch toast
            $message = __('messages.errors.try_error', ['code' => $e->getCode()]);
            # log error
            error_log("Error => " . $e->getMessage());
        }

        # reset form
        $this->reset();

        # return true
        return $message;


    }

}
