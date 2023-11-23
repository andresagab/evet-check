<?php

namespace App\Livewire\Forms\Sys\People;

use App\Http\Controllers\admin\UserController;
use App\Models\Sys\Person;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Rule;
use Livewire\Form;

class Frm extends Form
{

    /// PROPERTIES

    /**
     * Person model resource
     * @var Person|null
     */
    public ?Person $person;

    /**
     * The names attribute
     * @prop string
     */
    public $names = '';

    /**
     * The surnames attribute
     * @prop string
     */
    public $surnames = '';

    /**
     * The nuip attribute
     * @prop string
     */
    public $nuip = '';

    /**
     * The sex attribute
     * @prop string
     */
    public $sex = '';

    /**
     * The cel attribute
     * @prop string
     */
    public $cel = '';

    /**
     * The phone attribute
     * @prop string
     */
    public $phone = '';

    /**
     * The email attribute
     * @prop string
     */
    public $email = '';

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
            # person rules
            'names' => [
                'required',
                'string',
                'max:50',
            ],
            'surnames' => [
                'required',
                'string',
                'max:50',
            ],
            'nuip' => [
                'required',
                'string',
                'max:20',
            ],
            'sex' => [
                'nullable',
                'string',
                'max:1',
            ],
            'cel' => [
                'nullable',
                'string',
                'max:15',
            ],
            'phone' => [
                'nullable',
                'string',
                'max:15',
            ],
            'email' => [
                'nullable',
                'string',
                'max:150',
            ],
            # user rules
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

        # if not empty $this->person, then create custom validation to update a resource
        if (!empty($this->person))
        {
            $rules['nuip'][] = "unique:people,nuip,{$this->person->id}";
            $rules['cel'][] = "unique:people,cel,{$this->person->id}";
            $rules['email'][] = "unique:people,email,{$this->person->id}";
        }
        # else, then create custom validation for create new resource
        else
        {
            # unique rule for 'code'
            $rules['nuip'][] = "unique:people,nuip";
            $rules['cel'][] = "unique:people,cel";
            $rules['email'][] = "unique:people,email";
        }

        # if not empty $this->user, then create custom validation to update a resource
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
     * @param Person $person
     * @return void
     */
    public function set_form_data(Person $person) : void
    {
        # set person
        $this->person = $person;
        # set person form attributes
        $this->names = $this->person->names;
        $this->surnames = $this->person->surnames;
        $this->nuip = $this->person->nuip;
        $this->sex = $this->person->sex;
        $this->cel = $this->person->cel;
        $this->phone = $this->person->phone;
        $this->email = $this->person->email;

        # set user
        $this->user = $person->user;
        # set form attributes
        $this->name = $person->user->name;
        $this->code = $person->user->code;
        $this->state = $person->user->state;
        $this->role_name = $person->user->getRole()->name ?? null;

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

            # store user
            $user = UserController::store($this->only('name', 'code', 'state', 'final_password', 'role_name'));

            # if user was stored
            if ($user)
            {

                # store person
                Person::create([
                    'names' => $this->names,
                    'surnames' => $this->surnames,
                    'nuip' => $this->nuip,
                    'sex' => $this->sex,
                    'cel' => $this->cel,
                    'phone' => $this->phone,
                    'email' => $this->email,
                    'user_id' => $user->id,
                ]);

            }
            # else, then set message as not saved
            else
                $message = __('messages.responses.not_saved');

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

            # update user data and set message
            $user_update = UserController::update($this->user->id, $this->only(['name', 'code', 'state', 'password', 'final_password', 'role_name']));

            if ($user_update['state'])
            {

                # load person from db
                $person = Person::query()->find($this->person->id);

                # set attributes
                $person->names = $this->names;
                $person->surnames = $this->surnames;
                $person->nuip = $this->nuip;
                $person->sex = $this->sex;
                $person->cel = $this->cel;
                $person->phone = $this->phone;
                $person->email = $this->email;

                # update data, if not then set wrong message
                if (!$person->update())
                    $message = __('messages.errors.not_updated');

            }
            # else, set message as user not updated
            else
                $message = __('messages.models.user.model_name') . ": " . $user_update['message'];

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
