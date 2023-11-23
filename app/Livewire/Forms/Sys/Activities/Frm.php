<?php

namespace App\Livewire\Forms\Sys\Activities;

use App\Models\Sys\Activity;
use Livewire\Attributes\Rule;
use Livewire\Form;

class Frm extends Form
{

    /// PROPERTIES

    /**
     * Activity model resource
     * @var Activity|null
     */
    public ?Activity $activity;

    /**
     * The event_id attribute
     * @prop string
     */
    public $event_id = null;

    /**
     * The name attribute
     * @prop string
     */
    public $name = '';

    /**
     * The author_name attribute
     * @prop string
     */
    public $author_name = '';

    /**
     * The slots attribute
     * @prop string
     */
    public $slots = 0;

    /**
     * The type attribute
     * @prop string
     */
    public $type = '';

    /**
     * The modality attribute
     * @prop string
     */
    public $modality = '';

    /**
     * The status attribute
     * @prop string
     */
    public $status = '';

    /**
     * The hidden attribute
     * @prop string
     */
    public $hidden = '';

    /**
     * The date attribute
     * @prop string
     */
    public $date = '';

    /// PUBLIC FUNCTIONS

    /**
     * Define rules of form
     * @return array|array[]
     */
    public function rules()
    {
        # define rules
        $rules = [
            # activity rules
            'event_id' => [
                'required',
            ],
            'name' => [
                'required',
                'string',
                'max:250',
            ],
            'author_name' => [
                'required',
                'string',
                'max:250',
            ],
            'slots' => [
                'required',
                'numeric',
                'min:0',
                'max:99999',
            ],
            'type' => [
                'required',
                'string',
                'max:2',
            ],
            'modality' => [
                'required',
                'string',
                'max:1',
            ],
            'status' => [
                'required',
                'string',
                'max:1',
            ],
            'hidden' => [
                'required',
            ],
            'date' => [
                'required',
                'date',
            ],
        ];

        return $rules;

    }

    /**
     * Set attributes and model resource of form
     * @param Activity $activity
     * @return void
     */
    public function set_form_data(Activity $activity) : void
    {
        # set activity
        $this->activity = $activity;
        # set activity form attributes
        $this->event_id = $this->activity->event_id;
        $this->name = $this->activity->name;
        $this->author_name = $this->activity->author_name;
        $this->slots = $this->activity->slots;
        $this->type = $this->activity->type;
        $this->modality = $this->activity->modality;
        $this->status = $this->activity->status;
        $this->hidden = $this->activity->hidden;
        $this->date = $this->activity->date;

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

            # define new empty activity
            $activity = new Activity();
            # set attributes
            $activity->event_id = $this->event_id;
            $activity->name = $this->name;
            $activity->author_name = $this->author_name;
            $activity->slots = $this->slots;
            $activity->type = $this->type;
            $activity->modality = $this->modality;
            $activity->status = $this->status;
            $activity->hidden = $this->hidden;
            $activity->date = $this->date;

            # if activity was not saved
            if (!$activity->save())
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

            # load activity from db
            $activity = Activity::query()->find($this->activity->id);

            # set attributes
            $activity->event_id = $this->event_id;
            $activity->name = $this->name;
            $activity->author_name = $this->author_name;
            $activity->slots = $this->slots;
            $activity->type = $this->type;
            $activity->modality = $this->modality;
            $activity->status = $this->status;
            $activity->hidden = $this->hidden;
            $activity->date = $this->date;

            # update data, if not then set wrong message
            if (!$activity->update())
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
