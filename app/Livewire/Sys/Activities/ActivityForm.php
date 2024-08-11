<?php

namespace App\Livewire\Sys\Activities;

use App\Livewire\Forms\Sys\Activities\Frm;
use App\Models\Sys\Activity;
use App\Models\Sys\Location;
use App\Utils\Threads\FormThread;
use Livewire\Attributes\On;
use Livewire\Component;

class ActivityForm extends Component
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

    /// HOOKS

    /**
     * When component is mounted
     * @return void
     */
    public function mount(): void
    {
        # set init values
        $this->activity = new Activity();
    }

    /// PRIVATE FUNCTIONS



    /// PUBLIC FUNCTIONS

    /// EVENTS

    /**
     * Open modal component and setting an action
     * @param string $action => key of action to set in the component ('add' for create new resources or 'edit' to update old resources)
     * @param Activity|null $activity
     * @return void
     */
    #[On('open-modal')]
    public function openModal(string $action, ?Activity $activity): void
    {

        # always reset Activity model
        $this->activity = new Activity();
        # set action
        $this->action = $action;
        # always reset frm
        $this->frm->reset();
        # always unselect searched models
        $this->dispatch('unselect-model')->to('sys.locations.searcher');

        # if $person is not null
        if ($action === 'edit' && $activity)
        {
            # set User model
            $this->activity = $activity;
            # model in frm
            $this->frm->set_form_data($activity);
            # select searched models
            if ($activity->location_id)
                $this->dispatch('select-model', $this->activity->location)->to('sys.locations.searcher');
        }

        # open modal
        $this->open = true;

    }

    /**
     * Set searched model in Frm
     *
     * @param Location $location
     * @return void
     */
    #[On('select-location')]
    public function select_person(Location $location): void
    {
        $this->frm->location_id = $location->id;
    }

    /**
     * Unselect searched model in Frm
     *
     * @return void
     */
    #[On('unselect-location')]
    public function unselect_location(): void
    {
        $this->frm->reset('location_id');
    }

    /**
     * Render view of component
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.sys.activities.activity-form');
    }
}
