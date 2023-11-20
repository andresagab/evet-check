<?php

namespace App\Livewire\Sys\Activities;

use App\Livewire\Forms\Sys\Activities\Frm;
use App\Models\Sys\Activity;
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

        # if $person is not null
        if ($action === 'edit' && $activity)
        {
            # set User model
            $this->activity = $activity;
            # model in frm
            $this->frm->set_form_data($activity);
        }

        # open modal
        $this->open = true;

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
