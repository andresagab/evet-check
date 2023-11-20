<?php

namespace App\Livewire\Sys\Activities;

use App\Models\Sys\Activity;
use App\Utils\Threads\DeleteThread;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ActivityDelete extends Component
{

    /// USING

    use DeleteThread;

    /// PROPERTIES

    /**
     * The main model resource
     * @var Activity
     */
    public Activity $activity;

    /// HOOKS

    /**
     * When component is mounted
     * @return void
     */
    public function mount(): void
    {
        # init default values
        $this->activity = new Activity();
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

                # load Activity from db
                $activity = Activity::query()->find($this->activity->id);

                # if activity was deleted
                if ($activity->delete())
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
     * @param Activity $activity => the model resource
     * @return void
     */
    #[On('open-modal')]
    public function open_modal(Activity $activity): void
    {

        # always refresh model value
        $this->activity = new Activity();
        # if model is not null
        if ($activity)
        {
            # set model value
            $this->activity = $activity;
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
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.sys.activities.activity-delete');
    }
}
