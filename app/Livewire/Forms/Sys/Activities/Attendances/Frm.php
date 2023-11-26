<?php

namespace App\Livewire\Forms\Sys\Activities\Attendances;

use Livewire\Attributes\Rule;
use Livewire\Form;
use App\Models\Sys\Activity;
use App\Models\Sys\ActivityAttendance;
use App\Models\Sys\Person;


class Frm extends Form
{
    /// PROPERTIES

    /**
     * Activiy model resource
     * @var Activity|null
     */
    public ?Activity $activity;

    /**
     * Activity attendance model resource
     * @var ActivitytAttendance|null
     */
    public ?ActivityAttendance $attendance;

    /**
     * The person_id attribute
     * @prop string
     */
    public $person_id = '';

    /**
     * The type attribute
     * @prop string
     */
    public $state = '';

    /**
     * The date attribute
     * @prop string
     */
    public $attendance_date  = '';



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
        $message = 'La persona seleccionada puede ser registrada en esta actividad';

        # if attendance not have id or person_id form is different of attendance
        if (empty($this->attendance) || $this->person_id !== $this->attendance->person_id)
        {
            # count attendances by person_id and activity_id
            $person_attendances = ActivityAttendance::query()->where('activity_id', $this->activity->id)->where('person_id', $this->person_id)->count();

            # search person
            $person = Person::query()->find($this->person_id);

            # if person have attendances in current event, then set message
            if ($person_attendances > 0)
            {
                $can = false;
                $message = "{$person->getFullName()} ya está " . ($person->sex == 'F' ? 'registrada' : 'registrado') . " en esta actividad";
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
            # activity rules
            'person_id' => [
                'required',
            ],
            'state' => [
                'required',
                'string',
                'max:2',
            ],
            'attendance_date' => [
                'nullable',
            ],

        ];

        return $rules;

    }

    /**
     * Set main resource model
     * @param Activity $event
     * @return void
     */
    public function set_main_resource(Activity $activity) : void
    {
        $this->activity = $activity;
    }

    /**
     * Set attributes and model resource of form
     * @param ActivityAttendance $attendance
     * @return void
     */
    public function set_form_data(ActivityAttendance $attendance) : void
    {
        # set attendance
        $this->attendance = $attendance;
        # set form attributes
        $this->person_id = $this->attendance->person_id;
        $this->state = $this->attendance->state;
        $this->attendance_date = $this->attendance->attendance_date;
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

        # load person
        $person = Person::query()->find($this->person_id);
        # if person can register activity
        if (!empty($person) && $person->can_register_activity($this->activity))
        {

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
                    $attendance = new ActivityAttendance();
                    # set attributes
                    $attendance->activity_id = $this->activity->id;
                    $attendance->person_id = $this->person_id;
                    $attendance->state = $this->state;
                    $attendance->attendance_date = $this->attendance_date != '' ? $this->attendance_date : null;



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

        }
        # else, set custom message error
        else
            $message = "Esta persona ya tiene inscrita otra actividad en la misma hora y fecha, o la actividad ya no tiene cupos disponibles";

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

        # load person
        $person = Person::query()->find($this->person_id);
        # if person can register activity
        if (!empty($person) && $person->can_register_activity($this->activity))
        {
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
                    $attendance = ActivityAttendance::query()->find($this->attendance->id);

                    # set attributes
                    $attendance->person_id = $this->person_id;
                    $attendance->state = $this->state;
                    $attendance->attendance_date = $this->attendance_date != '' ? $this->attendance_date : null;

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

        }
        # else, set custom message error
        else
            $message = "Está persona ya tiene inscrita otra actividad en la misma hora y fecha";


        # reset form
        $this->reset();

        # return true
        return $message;

    }
}
