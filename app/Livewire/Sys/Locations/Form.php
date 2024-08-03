<?php

namespace App\Livewire\Sys\Locations;

use App\Livewire\Forms\Sys\Locations\Frm;
use App\Models\Sys\Location;
use App\Utils\Threads\FormThread;
use Livewire\Attributes\On;
use Livewire\Component;

class Form extends Component
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
     * The Location model
     * @var Location
     */
    public Location $location;

    /// HOOKS

    /**
     * When component is mounted
     * @return void
     */
    public function mount(): void
    {
        # set init values
        $this->location = new Location();
    }

    /// PRIVATE FUNCTIONS



    /// PUBLIC FUNCTIONS

    /// EVENTS

    /**
     * Open modal component and setting an action
     * @param string $action => key of action to set in the component ('add' for create new resources or 'edit' to update old resources)
     * @param Location|null $location
     * @return void
     */
    #[On('open-modal')]
    public function openModal(string $action, ?Location $location): void
    {

        # always reset Location model
        $this->location = new Location();
        # set action
        $this->action = $action;
        # always reset frm
        $this->frm->reset();

        # if $person is not null
        if ($action === 'edit' && $location)
        {
            # set User model
            $this->location = $location;
            # model in frm
            $this->frm->set_form_data($location);
        }

        # open modal
        $this->open = true;

    }

    /**
     * Render component
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.sys.locations.form');
    }
}
