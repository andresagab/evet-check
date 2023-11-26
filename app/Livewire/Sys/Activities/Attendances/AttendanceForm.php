<?php

namespace App\Livewire\Sys\Activities\Attendances;

use Livewire\Component;
use App\Livewire\Forms\Sys\Activities\Attendances\Frm;
use App\Models\Sys\Activity;
use App\Models\Sys\ActivityAttendance;
use App\Utils\Threads\FormThread;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;

class AttendanceForm extends Component
{
    /// USING
    use FormThread;

    /// PROPERTIES

    /**
     * The form object of this component
     * @var Frm
     */
    public Frm $frm;

    /**
     * The Activity model
     * @var Activity
     */
    public Activity $activity;

    public ActivityAttendance $attendance;

    /// HOOKS

    /**
     * When component is mounted
     * @return void
     */
    public function mount(): void
    {
        # set init values
        $this->activity = new Activity();
        $this->attendance = new ActivityAttendance();
    }

    /// PRIVATE FUNCTIONS



    /// PUBLIC FUNCTIONS

    /// EVENTS

    /**
     * Open modal component and setting an action
     * @param string $action => key of action to set in the component ('add' for create new resources or 'edit' to update old resources)
     * @param Activity $activity
     * @param ActivityAttendance|null $attendance
     * @return void
     */
    #[On('open-modal')]
    public function openModal(string $action, Activity $activity, ?ActivityAttendance $attendance): void
    {

        # always set Activity model
        $this->activity = $activity;
        # always reset ActivityAttendance model
        $this->attendance = new ActivityAttendance();
        # set action
        $this->action = $action;
        # always reset frm
        $this->frm->reset();
        # always set main resource model in form
        $this->frm->set_main_resource($this->activity);

        # if $person is not null
        if ($action === 'edit' && $attendance)
        {
            # set User model
            $this->attendance = $attendance;
            # model in frm
            $this->frm->set_form_data($attendance);
        }

        # open modal
        $this->open = true;

    }


    public function render()
    {
        return view('livewire.sys.activities.attendances.attendance-form');
    }
}
