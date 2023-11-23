<?php

namespace App\Livewire\Portal;

use App\Models\Sys\Activity;
use App\Models\Sys\ActivityAttendance;
use App\Models\Sys\Event;
use App\Models\Sys\Person;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Activities extends Component
{

    /// USING



    /// PROPERTIES

    /**
     * The Person model
     * @var Person
     */
    #[Locked]
    public Person $person;

    /**
     * The event model
     * @var Event
     */
    #[Locked]
    public Event $event;

    /**
     * The activities
     * @var array
     */
    #[Locked]
    public $activities = [];

    public $activities_dates = [];
    public $activities_hours = [];

    /// HOOKS

    /**
     * When component is mounted
     * @param $event_id
     * @param $person_id
     * @return void
     */
    public function mount($event_id, $person_id) : void
    {
        # set init values
        $this->person = Person::query()->find($person_id);
        $this->event = Event::query()->find($event_id);

        # pending add validation after search person and event
        $this->load_activities_dates();
    }

    /// PRIVATE FUNCTIONS

    /**
     * Get base query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function get_base_query(): \Illuminate\Database\Eloquent\Builder
    {

        $base_query = Activity::query()
            # link to events
            ->join('events as e', 'activities.event_id', '=', 'e.id')
            # link to event_attendances
            ->join('event_attendances as ea', 'e.id', '=', 'ea.event_id')
            # filter by event id
            ->where('e.id', $this->event->id)
            # filter by person id in event_attendances
            ->where('ea.person_id', $this->person->id)
            # not list hidden data
            ->where('activities.hidden', 0);

        return $base_query;

    }

    /**
     * Load dates of activities
     * @return void
     */
    private function load_activities_dates() : void
    {

        # load query
        $query = $this->get_base_query();

        # load activities dates
        $this->activities_dates = $query->selectRaw('DATE(activities.date) as activity_date')
            ->groupByRaw('activity_date')->orderBy('activity_date', 'ASC')->pluck('activity_date');

        # call to load hours
        $this->load_activities_hours();

    }

    /**
     * Load hours of activities
     * @return void
     */
    private function load_activities_hours() : void
    {
        # load query
        $query = $this->get_base_query();

        # load activities dates
        $this->activities_hours = $query->selectRaw('date')
            ->groupByRaw('date')->orderBy('date', 'ASC')->pluck('date');

        $this->load_activities();
    }

    /// PUBLIC FUNCTIONS

    /**
     * Load all activities
     * @return void
     */
    public function load_activities() : void
    {

        # load query
        $query = $this->get_base_query();

        # load activities from db
        $this->activities = $query
            # select only activities
            ->select('activities.*')
            # order by date and hour
            ->orderBy('date', 'ASC')
            ->get();
    }

    /**
     * Register attendance for a one activity
     * @param Activity $activity => the activity model to register a one attendance
     * @return void
     */
    public function register_activity(Activity $activity) : void
    {

        # check again if person can register activity
        if ($this->person->can_register_activity($activity))
        {
            # define empty attendance
            $attendance = new ActivityAttendance();
            # set attributes
            $attendance->activity_id = $activity->id;
            $attendance->person_id = $this->person->id;
            $attendance->state = 'SU';

            # if attendance is saved
            if ($attendance->save())
            {
                # dispatch success message
                $this->dispatch('alert', title:'¡INSCRIPCIÓN EXITOSA!', text:"Te inscribiste a: $activity->name", icon:'success');
                # load activities
                $this->load_activities();
            }
            else
                # dispatch not saved custom message
                $this->dispatch('alert', title:'¡INSCRIPCIÓN FALLIDA!', text:'No fue posible inscribir la actividad, intentalo nuevamente', icon:'warning');


        }

    }

    /// EVENTS




    /**
     * Render view of component
     * @return mixed
     */
    public function render(): mixed
    {
        return view('livewire.portal.activities')
            ->layout('components.layouts.pages.base-layout', [
                'tabTitle' => 'Actividades | Portal de asistencia',
            ]);
    }
}
