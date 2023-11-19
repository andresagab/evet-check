<?php

namespace App\Livewire\Forms\Sys\Events;

use App\Models\Sys\Event;
use Livewire\Form;

class Frm extends Form
{

    /// PROPERTIES

    /**
     * Event model resource
     * @var Event|null
     */
    public ?Event $event;

    /**
     * The name attribute
     * @prop string
     */
    public $name = '';

    /**
     * The year attribute
     * @prop string
     */
    public $year = '';

    /// PUBLIC FUNCTIONS

    /**
     * Define rules of form
     * @return array|array[]
     */
    public function rules()
    {
        # define rules
        $rules = [
            # event rules
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'year' => [
                'required',
                'string',
                'max:4',
            ],
        ];

        # if not empty $this->event, then create custom validation to update a resource
        if (!empty($this->event))
        {
            $rules['name'][] = "unique:events,name,{$this->event->id}";
        }
        # else, then create custom validation for create new resource
        else
        {
            # unique rule for 'name'
            $rules['name'][] = "unique:events,name";
        }

        return $rules;

    }

    /**
     * Set attributes and model resource of form
     * @param Event $event
     * @return void
     */
    public function set_form_data(Event $event) : void
    {
        # set event
        $this->event = $event;
        # set event form attributes
        $this->name = $this->event->name;
        $this->year = $this->event->year;

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

            # define new empty event
            $event = new Event();
            # set attributes
            $event->name = $this->name;
            $event->year = $this->year;

            # if event was not saved
            if (!$event->save())
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

            # load event from db
            $event = Event::query()->find($this->event->id);

            # set attributes
            $event->name = $this->name;
            $event->year = $this->year;

            # update data, if not then set wrong message
            if (!$event->update())
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
