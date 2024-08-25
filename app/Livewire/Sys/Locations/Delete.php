<?php

namespace App\Livewire\Sys\Locations;

use App\Models\Sys\Location;
use App\Utils\Threads\DeleteThread;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class Delete extends Component
{

    /// USING
    use DeleteThread;

    /// PROPERTIES

    /**
     * The main model resource
     * @var Location
     */
    #[Locked]
    public Location $location;

    /// HOOKS

    /**
     * When component is mounted
     * @return void
     */
    public function mount(): void
    {
        # init default values
        $this->location = new Location();
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

                # load Location from db
                $location = Location::query()->find($this->location->id);

                # if location was deleted
                if ($location->delete())
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
     * @param Location $location => the model resource
     * @return void
     */
    #[On('open-modal')]
    public function open_modal(Location $location): void
    {

        # always refresh model value
        $this->location = new Location();
        # if model is not null
        if ($location)
        {
            # set model value
            $this->location = $location;
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
     * Render component
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.sys.locations.delete');
    }
}
