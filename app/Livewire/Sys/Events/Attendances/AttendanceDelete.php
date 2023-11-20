<?php

namespace App\Livewire\Sys\Events\Attendances;

use App\Models\Sys\EventAttendance;
use App\Utils\Threads\DeleteThread;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class AttendanceDelete extends Component
{

    /// USING

    use DeleteThread;

    /// PROPERTIES

    /**
     * The main model resource
     * @var EventAttendance
     */
    public EventAttendance $attendance;

    /// HOOKS

    /**
     * When component is mounted
     * @return void
     */
    public function mount(): void
    {
        # init default values
        $this->attendance = new EventAttendance();
    }

    /// PRIVATE FUNCTIONS



    /// PUBLIC FUNCTIONS

    /**
     * Delete a resource
     * @return void
     */
    public function delete(): void
    {

        # if user is signed
        if (Auth::check())
        {

            # use try
            try {

                # load EventAttendance from db
                $attendance = EventAttendance::query()->find($this->attendance->id);

                # if attendance was deleted
                if ($attendance->delete())
                {
                    # dispatch message
                    $this->dispatch('toast', title:__('messages.responses.deleted'));
                    # dispatch to load data
                    $this->dispatch('search', true, false);
                }
                # else, dispatch toast with not deleted message
                else
                    $this->dispatch('toast', title:__('messages.responses.not_deleted'), icon:'warning');

                # close modal
                $this->open = false;

            }
            catch (\Exception $e)
            {
                $this->dispatch_try_catch($e);
            }

        }

    }

    /// EVENTS

    /**
     * Open modal component and setup to delete
     * @param EventAttendance $attendance => the model resource
     * @return void
     */
    #[On('open-modal')]
    public function open_modal(EventAttendance $attendance): void
    {

        # always refresh model value
        $this->attendance = new EventAttendance();
        # if model is not null
        if ($attendance)
        {
            # set model value
            $this->attendance = $attendance;
            # open modal
            $this->open = true;
        }
        # else
        else
        {
            # close modal
            $this->open = false;
            # emit toast error message
            $this->dispatch('toast', __('messages.error.record_not_loaded'), 'warning');
        }

    }

    /**
     * Render view of component
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.sys.events.attendances.attendance-delete');
    }
}
