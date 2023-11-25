<?php

namespace App\Livewire\Sys\Activities;

use App\Models\Sys\Activity;
use App\Models\Sys\ActivityAttendance;
use App\Models\Sys\Person;
use Livewire\Attributes\On;
use Livewire\Component;

class RegisterAttendance extends Component
{

    /// USING

    /// PROPERTIES

    /**
     * The open state to show dialog
     * @var bool
     */
    public bool $open = false;

    /**
     * The Activity model
     * @var Activity
     */
    public Activity $activity;

    /**
     * The Person model
     * @var Person
     */
    public Person $person;

    /**
     * The Activity Attendance model
     * @var ActivityAttendance
     */
    public ActivityAttendance $attendance;

    /**
     * The people collection
     * @var array
     */
    public $people = [];

    /**
     * The available filters
     * @var string[]
     */
    public $filters = [
        'person' => '',
    ];

    /// HOOKS

    /**
     * When component is mounted
     * @return void
     */
    public function mount(): void
    {
        # set init values
        $this->activity = new Activity();
        # $this->activity = Activity::find(9);
        $this->person = new Person();
        # $this->person = Person::find(5);
        $this->attendance = new ActivityAttendance();
        # $this->load_attendance();
        #$this->open = true;
    }

    /// PRIVATE FUNCTIONS

    /**
     * Load the Activity Attendance model for current activity and selected person
     * @return void
     */
    private function load_attendance() : void
    {
        # always reset attendance model
        $this->attendance = new ActivityAttendance();
        # if person model have id
        if ($this->person->id)
        {
            # search attendance by activity id and person id
            $attendance = ActivityAttendance::query()
                ->where('activity_id', $this->activity->id)
                ->where('person_id', $this->person->id)
                ->first();

            # if attendance was fund
            if (!empty($attendance))
            {
                # set attendance model
                $this->attendance = $attendance;
            }
            /*else
                $this->dispatch('alert', title:'INSCRIPCIÓN NO REALIZADA', text:"La persona con número de identificación {$this->person->nuip}, no tiene inscrita la actividad: '{$this->activity->name}'; por ende, no es posible realizar el registro de asistencia", icon:'error');*/

        }
        else
            $this->dispatch('toast', title:'Asegurate de buscar a una persona', icon:'info');
    }

    /// PUBLIC FUNCTIONS

    /**
     * Search people by names, surnames or dni
     * @return void
     */
    public function search_people() : void
    {

        # search people in db
        $this->people = Person::query()
            # filter by person, name, surnames or nuip
            ->where(function ($q) {
                # define $filter for current where
                $filter = "%" . mb_strtolower($this->filters['person'], 'UTF-8') . "%";
                # if $this->filters['person'] have data
                if ($this->filters['person'] != '')
                    # filter by names, surnames or nuip
                    return $q->whereRaw('LOWER(names) LIKE ?', [$filter])
                        ->orWhereRaw('LOWER(surnames) LIKE ?', [$filter])
                        ->orWhereRaw('LOWER(nuip) LIKE ?', [$filter]);
                else
                    return null;
            })
            ->orderBy('names', 'asc')
            ->get();
        # if count of people is equal to 1, then select directly this record
        if (count($this->people) === 1)
            $this->select_person($this->people[0]);
    }

    /**
     * Select a person
     * @param Person $person
     * @return void
     */
    public function select_person(Person $person) : void
    {
        # set person model
        $this->person = $person;
        # set person filter
        $this->filters['person'] = $this->person->getFullName();
        # load attendance
        $this->load_attendance();
        # reset people collection
        $this->reset(['people']);
    }

    /**
     * Remove or unselect loaded Person model
     * @return void
     */
    public function remove_person() : void
    {
        # set Person model as new empty model
        $this->person = new Person();
        # set Activity Attendance model as new empty model
        $this->attendance = new ActivityAttendance();
        # reset filter
        $this->reset(['filters']);
    }

    /**
     * Register attendance for current activity and loaded person
     * @return void
     */
    public function register_attendance() : void
    {
        # if person model and activity attendance model have id
        if ($this->person->id && $this->attendance->id)
        {
            # load attendance from db
            $attendance = ActivityAttendance::query()->find($this->attendance->id);

            # if attendance was loaded
            if (!empty($attendance))
            {
                # set attributes
                $attendance->state = 'DO';
                $attendance->attendance_date = now();

                # if attendance is updated
                if ($attendance->update())
                {
                    # dispatch success message
                    $this->dispatch('toast', title:'Asistencia registrada exitosamente');
                    # load attendance again
                    $this->attendance = $attendance;
                }
                # else, dispatch not updated message
                else
                    $this->dispatch('toast', title:__('messages.errors.not_updated'), icon:'warning');

            }
            # else, dispatch custom message of record not loaded
            else
                $this->dispatch('toast', title:'No fue posible cargar el registro de asistencia, intentalo nuevamente', icon:'warning');

        }
    }

    /// EVENTS

    /**
     * Open modal component and setting an action
     * @param Activity $activity
     * @return void
     */
    #[On('open-modal')]
    public function openModal(Activity $activity): void
    {

        # always reset Activity model
        $this->activity = new Activity();
        # always reset Person model
        $this->person = new Person();
        # always reset ActivityAttendance model
        $this->attendance = new ActivityAttendance();
        # reset people and filters
        $this->reset(['people', 'filters']);

        # if $person is not null
        if ($activity)
        {
            # set User model
            $this->activity = $activity;
            # open modal
            $this->open = true;
        }

    }

    /**
     * Render view of component
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.sys.activities.register-attendance');
    }
}
