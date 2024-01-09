<?php

namespace App\Livewire\Portal;

use App\Models\Sys\EventAttendance;
use App\Models\Sys\Person;
use App\Utils\Threads\FormThread;
use Livewire\Attributes\On;
use Livewire\Component;

class RegisterEventAttendance extends Component
{

    /// USING
    use FormThread;

    /// PROPERTIES

    /**
     * The Person model
     * @var Person
     */
    public Person $person;

    /**
     * The form array attributes
     */
    public array $frm = [
        'event_id' => '',
        'institution_id' => '',
        'other_institution' => '',
        'participation_modality' => '',
        'type' => '',
        'stay_type' => '',
        ];

    /// HOOKS

    /**
     * When component is mounted
     * @return void
     */
    public function mount(): void
    {
        # set init values
        $this->person = new Person();
    }

    /**
     * Define rules of form
     * @return array|array[]
     */
    public function rules()
    {
        # define rules
        $rules = [
            'frm.event_id' => [
                'required',
                'string',
                'min:1',
            ],
            'frm.institution_id' => [
                'required',
            ],
            'frm.other_institution' => [
                "required_if:frm.institution_id,1",
                'string',
                'max:250',
            ],
            'frm.participation_modality' => [
                'required',
                'string',
                'max:2',
            ],
            'frm.type' => [
                'required',
                'string',
                'max:2',
            ],
            'frm.stay_type' => [
                'required',
                'string',
                'max:1',
            ],
        ];

        # if participation modality is 'ws' or participation_modality is 'AS' and type is 'SL' or 'EL', then set stay_type as 'P' (in person)
        if (in_array($this->frm['participation_modality'], ['WS', 'OR']) || ($this->frm['participation_modality'] === 'AS' && in_array($this->frm['type'], ['SL', 'EL'])))
            $this->frm['stay_type'] = 'P';

        return $rules;

    }

    /// PRIVATE FUNCTIONS



    /// PUBLIC FUNCTIONS

    /**
     * Submit form data and save it
     * @return void
     */
    public function submit(): void
    {

        # validate form data
        $this->validate();

        # define a new event attendance model
        $attendance = new EventAttendance();
        # set attributes of model
        $attendance->event_id = $this->frm['event_id'];
        $attendance->person_id = $this->person->id;
        $attendance->institution_id = $this->frm['institution_id'];
        $attendance->other_institution = $this->frm['other_institution'];
        $attendance->participation_modality = $this->frm['participation_modality'];
        $attendance->type = $this->frm['type'];
        $attendance->stay_type = $this->frm['stay_type'];
        $attendance->payment_status = 'NP';
        $attendance->approve_certificate_manually = 0;

        # use try catch to store data
        try {
            # if model data was saved
            if ($attendance->save())
            {
                # emit toast
                $this->dispatch('toast', title:'Inscripción realizada exitosamente');
                # dispatch up to reload the registered events attendance list
                $this->dispatch('load-registered-events');
                # close modal
                $this->open = false;
            }
            else
                $this->dispatch('toast', title:'Inscripción no realizada, intentalo nuevamente', icon:'warning');
        }
        catch (\Exception $e)
        {
            # dispatch toast
            $this->dispatch('toast', title:__('messages.errors.try_error', ['code' => $e->getCode()]), icon:'error');
            # log error
            error_log("Error => " . $e->getMessage());
            # close modal
            $this->open = false;
        }

    }

    /// EVENTS

    /**
     * Open modal component and setting an action
     * @param Person $person => the person model
     * @return void
     */
    #[On('open-modal')]
    public function openModal(Person $person): void
    {

        # always reset Person model
        $this->person = $person->refresh();
        # always reset form data
        $this->reset(['frm']);
        # open modal
        $this->open = true;

    }


    /**
     * Render view of component
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.portal.register-event-attendance');
    }
}
