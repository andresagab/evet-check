<?php

namespace App\Livewire\Forms\Sys\Events\Attendances;

use App\Models\Sys\Event;
use App\Models\Sys\EventAttendance;
use App\Models\Sys\Person;
use Illuminate\Support\Facades\Auth;
use Laratrust\Laratrust;
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
     * Event attendance model resource
     * @var EventAttendance|null
     */
    public ?EventAttendance $attendance;

    /**
     * The person_id attribute
     * @prop string
     */
    public $person_id = '';

    /**
     * The institution_id attribute
     * @prop string
     */
    public $institution_id = '';

    /**
     * The other_institution attribute
     * @prop string
     */
    public $other_institution = '';

    /**
     * The participation_modality attribute
     * @prop string
     */
    public $participation_modality = '';

    /**
     * The type attribute
     * @prop string
     */
    public $type = '';

    /**
     * The stay_type attribute
     * @prop string
     */
    public $stay_type = '';

    /**
     * The payment_status attribute
     * @prop string
     */
    public $payment_status = 'NP';

    /**
     * The approve_certificate_manually attribute
     * @prop string
     */
    public $approve_certificate_manually = 0;

    /// PRIVATE FUNCTIONS

    /**
     * Check if selected person can be stored attendance in current event
     * @return array => 'can' with true or false, 'message' with custom info of verification
     */
    private function can_save() : array
    {
        # define $can as true
        $can = true;
        # define default message
        $message = 'La persona seleccionada puede ser registrada en este evento';

        # if attendance not have id or person_id form is different of attendance
        if (empty($this->attendance) || $this->person_id !== $this->attendance->person_id)
        {
            # count attendances by person_id and event_id
            $person_attendances = EventAttendance::query()->where('event_id', $this->event->id)->where('person_id', $this->person_id)->count();

            # search person
            $person = Person::query()->find($this->person_id);

            # if person have attendances in current event, then set message
            if ($person_attendances > 0)
            {
                $can = false;
                $message = "{$person->getFullName()} ya está " . ($person->sex == 'F' ? 'registrada' : 'registrado') . " en este evento";
            }
        }


        return [
            'can' => $can,
            'message' => $message,
        ];
    }

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
            'person_id' => [
                'required',
            ],
            'institution_id' => [
                'required',
            ],
            'other_institution' => [
                "required_if:frm.institution_id,1",
                'string',
                'max:250',
            ],
            'participation_modality' => [
                'required',
                'string',
                'max:2',
            ],
            'type' => [
                'required',
                'string',
                'max:2',
            ],
            'stay_type' => [
                'required',
                'string',
                'max:1',
            ],
            'payment_status' => [
                'string',
                'max:2',
            ],
            'approve_certificate_manually' => [
                'boolean',
                'max:1',
            ],
        ];

        # add rule if user or role have permission 'event_attendances:set_as_paid'
        if (Auth::user()->ability('*', 'event_attendances:set_as_paid'))
            $rules['payment_status'][] = 'required';

        # add rule if user or role have permission 'event_attendances:set_approve_certificate_manually'
        if (Auth::user()->ability('*', 'event_attendances:set_approve_certificate_manually'))
            $rules['approve_certificate_manually'][] = 'required';

        # if participation modality is 'ws' or participation_modality is 'AS' and type is 'SL' or 'EL', then set stay_type as 'P' (in person)
        if ($this->participation_modality === 'WS' || ($this->participation_modality === 'AS' && in_array($this->type, ['SL', 'EL'])))
            $this->stay_type = 'P';

        return $rules;

    }

    /**
     * Set main resource model
     * @param Event $event
     * @return void
     */
    public function set_main_resource(Event $event) : void
    {
        $this->event = $event;
    }

    /**
     * Set attributes and model resource of form
     * @param EventAttendance $attendance
     * @return void
     */
    public function set_form_data(EventAttendance $attendance) : void
    {
        # set attendance
        $this->attendance = $attendance;
        # set form attributes
        $this->person_id = $this->attendance->person_id;
        $this->institution_id = $this->attendance->institution_id;
        $this->other_institution = $this->attendance->other_institution;
        $this->participation_modality = $this->attendance->participation_modality;
        $this->type = $this->attendance->type;
        $this->stay_type = $this->attendance->stay_type;
        $this->payment_status = $this->attendance->payment_status;
        $this->approve_certificate_manually = $this->attendance->approve_certificate_manually;
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

            # check if attendance can be saved for current person
            $can_response = $this->can_save();

            # if can_response is false, then set message
            if (!$can_response['can'])
                $message = $can_response['message'];
            # else, store attendance
            else
            {

                # define new empty attendance
                $attendance = new EventAttendance();
                # set attributes
                $attendance->event_id = $this->event->id;
                $attendance->person_id = $this->person_id;
                $attendance->institution_id = $this->institution_id;
                $attendance->other_institution = $this->other_institution;
                $attendance->participation_modality = $this->participation_modality;
                $attendance->type = $this->type;
                $attendance->stay_type = $this->stay_type;
                $attendance->payment_status = $this->payment_status;
                $attendance->approve_certificate_manually = $this->approve_certificate_manually;

                # if attendance was not saved
                if (!$attendance->save())
                    $message = __('messages.responses.not_saved');

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

            # check if attendance can be saved for current person
            $can_response = $this->can_save();

            # if can_response is false, then set message
            if (!$can_response['can'])
                $message = $can_response['message'];
            # else, update attendance
            else
            {

                # load attendance from db
                $attendance = EventAttendance::query()->find($this->attendance->id);

                # set attributes
                $attendance->person_id = $this->person_id;
                $attendance->institution_id = $this->institution_id;
                $attendance->other_institution = $this->other_institution;
                $attendance->participation_modality = $this->participation_modality;
                $attendance->type = $this->type;
                $attendance->stay_type = $this->stay_type;
                $attendance->payment_status = $this->payment_status;
                $attendance->approve_certificate_manually = $this->approve_certificate_manually;

                # update data, if not then set wrong message
                if (!$attendance->update())
                    $message = __('messages.errors.not_updated');

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

}
