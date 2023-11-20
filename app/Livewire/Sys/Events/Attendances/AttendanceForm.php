<?php

namespace App\Livewire\Sys\Events\Attendances;

use App\Livewire\Forms\Sys\Events\Attendances\Frm;
use App\Models\Sys\Event;
use App\Models\Sys\EventAttendance;
use App\Utils\Threads\FormThread;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;
use Livewire\Component;

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
     * The Event model
     * @var Event
     */
    public Event $event;

    public EventAttendance $attendance;

    /// HOOKS

    /**
     * When component is mounted
     * @return void
     */
    public function mount(): void
    {
        # set init values
        $this->event = new Event();
        $this->attendance = new EventAttendance();
    }

    /// PRIVATE FUNCTIONS



    /// PUBLIC FUNCTIONS

    /// EVENTS

    /**
     * Open modal component and setting an action
     * @param string $action => key of action to set in the component ('add' for create new resources or 'edit' to update old resources)
     * @param Event|null $event
     * @return void
     */
    #[On('open-modal')]
    public function openModal(string $action, Event $event, ?EventAttendance $attendance): void
    {

        # always set Event model
        $this->event = $event;
        # always reset EventAttendance model
        $this->attendance = new EventAttendance();
        # set action
        $this->action = $action;
        # always reset frm
        $this->frm->reset();
        # always set main resource model in form
        $this->frm->set_main_resource($this->event);

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

    /**
     * Render view fo component
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.sys.events.attendances.attendance-form');
    }
}
