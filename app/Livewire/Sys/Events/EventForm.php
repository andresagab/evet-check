<?php

namespace App\Livewire\Sys\Events;

use App\Livewire\Forms\Sys\Events\Frm;
use App\Models\Sys\Event;
use App\Utils\Threads\FormThread;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class EventForm extends Component
{

    /// USING
    use FormThread;
    use WithFileUploads;

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

    /// HOOKS

    /**
     * When component is mounted
     * @return void
     */
    public function mount(): void
    {
        # set init values
        $this->event = new Event();
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
    public function openModal(string $action, ?Event $event): void
    {

        # always reset Event model
        $this->event = new Event();
        # set action
        $this->action = $action;
        # always reset frm
        $this->frm->reset();

        # if $person is not null
        if ($action === 'edit' && $event)
        {
            # set User model
            $this->event = $event;
            # model in frm
            $this->frm->set_form_data($event);
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
        return view('livewire.sys.events.event-form');
    }
}
