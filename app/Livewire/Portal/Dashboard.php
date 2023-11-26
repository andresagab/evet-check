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

    /**
     * The events collection
     * @var array
     */
    #[Locked]
    public $events = [];

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

        # calls
        $this->load_registered_events();
    }

    /// PRIVATE FUNCTIONS

    /**
     * Load registered events of person
     * @return void
     */
    private function load_registered_events() : void
    {
        $this->events = Event::query()
            ->join('event_attendances as ea', 'events.id', '=', 'ea.event_id')
            ->where('ea.person_id', $this->person->id)
            ->select('events.*')
            ->orderBy('year', 'DESC')
            ->get();
    }

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

    /**
     * Open activities of event
     * @param Event $event
     * @return void
     */
    public function open_virtual_card(Event $event) : void
    {
        $this->redirectRoute('portal.event.virtual-card', ['event_id' => $event->id, 'person_id' => $this->person->id], navigate:true);
    }

    /// EVENTS



    /**
     * Render view of component
     * @return mixed
     */
    public function render(): mixed
    {
        return view('livewire.portal.dashboard')
            ->layout('components.layouts.pages.portal-layout', [
                'title' => 'Eventos',
            ]);
    }
}
