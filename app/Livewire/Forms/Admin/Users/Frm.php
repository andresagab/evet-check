<?php

namespace App\Livewire\Forms\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Rule;
use Livewire\Form;

class Frm extends Form
{

    /// PROPERTIES

    /**
     * Model of main resource
     * @var User|null
     */
    public ?User $user;

    /**
     * The name attribute
     * @prop string
     */
    public $name = '';

    /**
     * The code attribute
     * @prop string
     */
    public $code = '';

    /**
     * The state attribute
     * @prop string
     */
    public $state = '';

    /**
     * The state attribute
     * @prop string
     */
    public $role_name = '';

    /**
     * The password attribute
     * @prop string
     */
    public $password = '';

    /**
     * The password_confirmation attribute
     * @prop string
     */
    public $password_confirmation = '';

    /**
     * The final password
     * @var string
     */
    protected string $final_password = '';

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
            'code' => [
                'required',
                'string',
                'max:30',
            ],
            'state' => [
                'required',
                'string',
                'max:1',
            ],
            'role_name' => [
                'required',
                'string',
            ],
            'password' => [
                'nullable',
                'max:250',
            ],
            'password_confirmation' => [
                'nullable',
                'max:250',
            ],
        ];

        # if not empty $this->role, then create custom validation to update a resource
        if (!empty($this->user))
        {
            $rules['code'][] = "unique:users,code,{$this->user->id}";
        }
        # else, then create custom validation for create new resource
        else
        {
            # unique rule for 'code'
            $rules['code'][] = 'unique:users,code';
        }

        # if passwords.password is dirty, then validate password
        if ($this->password != '' || empty($this->user))
        {
            # validate password
            $rules['password'][] = 'required';
            $rules['password'][] = 'confirmed';
            $rules['password'][] = Password::min(5)->letters()->numbers();
            # set user password
            $this->final_password = Hash::make($this->password);
        }

        return $rules;

    }

    /**
     * Set attributes and model resource of form
     * @param User $user
     * @return void
     */
    public function set_form_data(User $user) : void
    {
        # set role
        $this->user = $user;
        # set form attributes
        $this->name = $user->name;
        $this->code = $user->code;
        $this->state = $user->state;
        $this->role_name = $user->getRole()->name ?? null;
    }

    /**
     * Store data
     * @return string
     */
    public function store() : string
    {

        # set state as 'A'
        $this->state = 'A';

        # validate fields
        $this->validate();

        # define state of action: 1 => saved, 2 => not_saved, 3 => try_error
        $message = __('messages.responses.saved');

        # use try
        try {

            # store data
            User::create([
                'name' => $this->name,
                'code' => $this->code,
                'state' => $this->state,
                'password' => $this->final_password,
            ]);

            # search user by code
            $user = User::query()->where('code', $this->code)->first();

            # if user was fund
            if ($user)
                # sync user role
                $user->syncRoles([$this->role_name]);
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
            $user = User::query()->find($this->user->id);

            # set fields
            $user->name = $this->name;
            $user->code = $this->code;
            $user->state = $this->state;

            # if 'password' is dirty, set password
            if ($this->password !== '')
                $user->password = $this->final_password;

            # update data, if not then set wrong message
            if (!$user->update())
                $message = __('messages.errors.not_updated');
            # else, sync roles
            else
                $user->syncRoles([$this->role_name]);

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
