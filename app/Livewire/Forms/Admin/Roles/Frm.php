<?php

namespace App\Livewire\Forms\Admin\Roles;

use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Rule;
use Livewire\Form;

class Frm extends Form
{

    /// PROPERTIES

    /**
     * Model of main resource
     * @var Role|null
     */
    public ?Role $role;

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
            'description' => [
                'nullable',
                'string',
                'max:250',
            ],
        ];

        # if not empty $this->role, then create custom validation to update a resource
        if (!empty($this->role))
        {
            $rules['name'][] = "unique:roles,name,{$this->role->id}";
        }
        # else, then create custom validation for create new resource
        else
        {
            $rules['name'][] = 'unique:roles,name';
        }

        return $rules;

    }

    /**
     * Set attributes and model resource of form
     * @param Role $role
     * @return void
     */
    public function set_role(Role $role) : void
    {
        # set role
        $this->role = $role;
        # set form attributes
        $this->name = $role->name;
        $this->display_name = $role->display_name;
        $this->description = $role->description;
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
            Role::create($this->only(['name', 'display_name', 'description']));

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
            $role = Role::query()->find($this->role->id);

            # update data
            if (!$role->update($this->all()))
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
