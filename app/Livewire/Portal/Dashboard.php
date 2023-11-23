<?php

namespace App\Livewire\Portal;

use App\Models\Sys\Event;
use App\Models\Sys\Person;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Dashboard extends Component
{

    /// USING



    /// PROPERTIES

    /**
     * The person model
     * @var Person
     */
    #[Locked]
    public Person $person;

    /// HOOKS

    /**
     * When component is mounted
     * @param Person $person
     * @return void
     */
    public function mount(Person $person) : void
    {
        # set init values
        $this->person = $person;
    }

    /// PRIVATE FUNCTIONS



    /// PUBLIC FUNCTIONS

    /**
     * Open activities of event
     * @param Event $event
     * @return void
     */
    public function open_activities(Event $event) : void
    {
        $this->redirectRoute('portal.event.activities', ['event_id' => $event->id, 'person_id' => $this->person->id], navigate:true);
    }

    /// EVENTS



    /**
     * Render view of component
     * @return mixed
     */
    public function render(): mixed
    {
        return view('livewire.portal.dashboard')
            ->layout('components.layouts.pages.base-layout', [
                'tabTitle' => 'Eventos | Portal de asistencia',
            ]);
    }
}
