<?php

namespace App\Livewire\Sys\Activities\Attendances;

use App\Models\Sys\ActivityAttendance;
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
     * @var ActivityAttendance
     */
    public ActivityAttendance $attendance;

    /// HOOKS

    /**
     * When component is mounted
     * @return void
     */
    public function mount(): void
    {
        # init default values
        $this->attendance = new ActivityAttendance();
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

                # load ActivityAttendance from db
                $attendance = ActivityAttendance::query()->find($this->attendance->id);

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
     * @param ActivityAttendance $attendance => the model resource
     * @return void
     */
    #[On('open-modal')]
    public function open_modal(ActivityAttendance $attendance): void
    {

        # always refresh model value
        $this->attendance = new ActivityAttendance();
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


    public function render()
    {
        return view('livewire.sys.activities.attendances.attendance-delete');
    }
}
