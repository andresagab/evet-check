<?php

namespace App\Livewire\Portal;

use App\Models\Sys\Event;
use App\Models\Sys\EventAttendance;
use App\Models\Sys\Person;
use Livewire\Attributes\Locked;
use Livewire\Component;

class VirtualCard extends Component
{

    /// USING



    /// PROPERTIES

    /**
     * The Person model
     * @var Person
     */
    #[Locked]
    public Person $person;

    /**
     * The Event model
     * @var Event
     */
    public Event $event;

    public string $participation_modality = '';

    /**
     * The virtual card setup
     * @var array
     */
    public array $setup = [];

    /// HOOKS

    /**
     * When component is mounted
     * @param $event_id
     * @param $person_id
     * @return void
     */
    public function mount($event_id, $person_id) : void
    {
        # search event in db
        $event = Event::query()->find($event_id);
        # search person in db
        $person = Person::query()->find($person_id);

        # if event and person were fund
        if (!empty($event) && !empty($person))
        {

            # load attendance of person in event
            $attendance = EventAttendance::query()->where('event_id', $event->id)->where('person_id', $person->id)->first();
            # if person is signed up in event
            if (!empty($attendance))
            {
                # if event is not completed
                if ($event->state !== 'CP')
                {
                    # set init values
                    $this->person = $person;
                    $this->event = $event;

                    # pending add validation after search person and event
                    $this->load_participation_modality();

                    # load virtual card setup
                    $this->setup = $this->event->get_virtual_card_setup();

                }
                # else, redirect to dashboard
                else
                    $this->redirectRoute('portal.dashboard', $person, navigate: true);
            }
            # else, redirect to dashboard
            else
                $this->redirectRoute('portal.dashboard', $person, navigate: true);

        }
        # else, redirect to home
        else
            $this->redirectRoute('portal.home', navigate: true);

    }

    /// PRIVATE FUNCTIONS

    /**
     * Load participation modality of person
     * @return void
     */
    private function load_participation_modality() : void
    {
        # load attendance of person in current event
        $event_attendance = $this->person->event_attendances()->where('event_id', $this->event->id)->first();
        # if a resource was loaded
        if (!empty($event_attendance))
            # set participation modality
            $this->participation_modality = __($event_attendance->get_participation_modality('key_name'));
        # else, set as unknown
        else
            $this->participation_modality = __('messages.data.unknown');
    }

    /// PUBLIC FUNCTIONS



    /// EVENTS




    /**
     * Render view of component
     * @return mixed
     */
    public function render(): mixed
    {
        return view('livewire.portal.virtual-card')
            ->layout('components.layouts.pages.portal-layout', [
                'title' => 'Carnet Virtual',
                'person' => $this->person,
                'event' => $this->event,
            ]);
    }
}
