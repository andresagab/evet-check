<?php

namespace App\Livewire\Forms\Sys\Locations;

use App\Models\Sys\Location;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class Frm extends Form
{

    /// PROPERTIES

    /**
     * Location model resource
     * @var Location|null
     */
    public ?Location $location;

    /**
     * The name attribute
     * @prop string
     */
    public $name = '';

    /**
     * The address attribute
     * @prop string
     */
    public $address = '';

    /**
     * The url attribute
     * @prop string
     */
    public $url = '';

    /**
     * The is_maps_location attribute
     * @prop string
     */
    public $is_maps_location = 0;

    /**
     * The active attribute
     * @prop string
     */
    public $active = 1;

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
                'max:500',
            ],
            'address' => [
                'nullable',
                'string',
                'max:500',
            ],
            'url' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'is_maps_location' => [
                'required',
                'boolean',
            ],
            'active' => [
                'required',
                'boolean',
            ],
        ];

        # add custom validations if the form is editing
        if (!empty($this->location))
        {
            # unique rule by name
            $rules['name'][] = Rule::unique('locations', 'name')->ignore($this->location->id);
        }
        # else, form is creating
        else
        {
            # unique rule by name
            $rules['name'][] = Rule::unique('locations', 'name');
        }

        if ($this->is_maps_location)
        {
            $rules['address'][] = 'required';
            $rules['url'][] = 'required';
        }

        return $rules;

    }

    /**
     * Set attributes and model resource of form
     * @param Location $location
     * @return void
     */
    public function set_form_data(Location $location) : void
    {
        # set location
        $this->location = $location;
        # set location form attributes
        $this->name = $this->location->name;
        $this->url = $this->location->url;
        $this->address = $this->location->address;
        $this->is_maps_location = $this->location->is_maps_location;
        $this->active = $this->location->active;

    }

    /**
     * Store data
     * @return string
     * @throws ValidationException
     */
    public function store() : string
    {

        # validate fields
        $this->validate();

        # define state of action: 1 => saved, 2 => not_saved, 3 => try_error
        $message = __('messages.responses.saved');

        # use try
        try {

            # define new empty location
            $location = new Location();
            # set attributes
            $location = $this->set_model_attributes($location);

            # if location was not saved
            if (!$location->save())
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
     * @throws ValidationException
     */
    public function update() : string
    {

        # validate fields
        $this->validate();

        # define state of action: 1 => saved, 2 => not_saved, 3 => try_error
        $message = __('messages.responses.updated');
        # use try
        try {

            # load location from db
            $location = Location::query()->find($this->location->id);
            # set attributes
            $location = $this->set_model_attributes($location);

            # update data, if not then set wrong message
            if (!$location->update())
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

    /// PRIVATE FUNCTIONS

    /**
     * Set the attributes of model
     * @param Location $model
     * @return Location
     */
    private function set_model_attributes(Location $model): Location
    {
        # set attributes
        $model->name = $this->name;
        $model->address = $this->address;
        $model->url = $this->url;
        $model->is_maps_location = $this->is_maps_location;
        $model->active = $this->active;

        # return modified model
        return $model;
    }

}
