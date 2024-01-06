<?php

namespace App\Livewire\Forms\Sys\Events;

use App\Models\Sys\Event;
use App\Utils\CommonUtils;
use Livewire\Form;
use Livewire\WithFileUploads;

class Frm extends Form
{

    /// USING
    use WithFileUploads;

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

    /**
     * The state attribute
     * @prop string
     */
    public $state = 'OP';

    /**
     * The symbolic_cost attribute
     * @prop string
     */
    public $symbolic_cost = '';

    /**
     * The certificate_path attribute
     * @prop string
     */
    public $certificate_path = '';

    /**
     * The min_percent attribute
     * @prop string
     */
    public $min_percent = '';

    /**
     * The certificate file
     * @var
     */
    public $certificate_file;

    /**
     * The virtual card file
     * @var
     */
    public $virtual_card_file;

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
            'state' => [
                'required',
                'string',
                'max:2',
            ],
            'symbolic_cost' => [
                'required',
                'numeric',
                'min:0',
            ],
            'certificate_file' => [
                'nullable',
                'image',
                'max:3062',
            ],
            'virtual_card_file' => [
                'nullable',
                'image',
                'max:3062',
            ],
            'min_percent' => [
                'nullable',
                'numeric',
                'min:1',
                'max:100',
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
        $this->event = $event->refresh();
        # set event form attributes
        $this->name = $this->event->name;
        $this->year = $this->event->year;
        $this->state = $this->event->state;
        $this->symbolic_cost = $this->event->symbolic_cost;
        $this->min_percent = $this->event->min_percent;

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
            $event->state = $this->state;
            $event->symbolic_cost = $this->symbolic_cost;
            $event->min_percent = $this->min_percent;

            # if event was not saved
            if (!$event->save())
                $message = __('messages.responses.not_saved');
            # else, continue saving files
            else
            {
                # store file of certificate and get path
                $certificate_path = $this->store_file($this->certificate_file, $event, 'public/events/certificates', 'certificate_template');
                # store file of virtual card and get path
                $virtual_card_path = $this->store_file($this->virtual_card_file, $event, 'public/events/virtual_cards', 'virtual_card_template');
                # if file was stored
                if ($certificate_path)
                    # set certificate_path in event model
                    $event->certificate_path = $certificate_path;
                # if file was stored
                if ($virtual_card_path)
                    # set certificate_path in event model
                    $event->virtual_card_path = $virtual_card_path;

                # update changes
                $event->update();

            }

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
            $event->state = $this->state;
            $event->symbolic_cost = $this->symbolic_cost;
            $event->min_percent = $this->min_percent;

            # update data, if not then set wrong message
            if (!$event->update())
                $message = __('messages.errors.not_updated');
            # else, continue saving files
            else
            {

                # store file of certificate and get path
                $certificate_path = $this->store_file($this->certificate_file, $event, 'public/events/certificates', 'certificate_template');
                # store file of virtual card and get path
                $virtual_card_path = $this->store_file($this->virtual_card_file, $event, 'public/events/virtual_cards', 'virtual_card_template');

                # if file was stored
                if ($certificate_path)
                    # set certificate_path in event model
                    $event->certificate_path = $certificate_path;
                # if file was stored
                if ($virtual_card_path)
                    # set certificate_path in event model
                    $event->virtual_card_path = $virtual_card_path;

                # update changes
                $event->update();

            }

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
     * Store file and return path
     * @param $file => The file object to store
     * @param Event $event => The event to save your file
     * @param string $path => The path to store file
     * @param string $filename => The common file name to be stored
     * @return null
     */
    private function store_file($file, Event $event, string $path, string $filename)
    {
        # define file name as null
        $file_name = null;

        # if file is not null
        if ($file)
        {
            # generate file name
            $file_name = CommonUtils::generateUniqueFileName($event->id, $filename);
            # load file extension
            $extension = CommonUtils::get_file_extension($file->getRealPath());
            $file_name = $file->storeAs($path, "$file_name.$extension");
        }

        return $file_name;
    }

}
