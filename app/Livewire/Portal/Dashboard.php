<?php

namespace App\Livewire\Portal;

use App\Models\Sys\Event;
use App\Models\Sys\EventAttendance;
use App\Models\Sys\Person;
use Barryvdh\DomPDF\Facade\Pdf;
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

    /**
     * The event attendances of person
     * @var array
     */
    #[Locked]
    public $attendances = [];

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
        $this->attendances = EventAttendance::query()
            # link to events
            ->join('events as e', 'event_attendances.event_id', '=', 'e.id')
            # filter by person_id
            ->where('person_id', $this->person->id)
            # select event_attendances
            ->select('event_attendances.*')
            # withs
            ->with(['event'])
            # order by year of event
            ->orderBy('year', 'DESC')
            ->get();


        /*$this->events = Event::query()
            ->join('event_attendances as ea', 'events.id', '=', 'ea.event_id')
            ->where('ea.person_id', $this->person->id)
            ->select('events.*')
            ->orderBy('year', 'DESC')
            ->get();*/
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

    public function generate_certificate(Event $event)
    {

        # event status validation
        if ($event->state === 'CP')
        {

            # person type and attendances validation
            if (1 === 1)
            {

                # define data of view
                $data = [
                    'event' => $event,
                    'person' => $this->person,
                    'event_attendance' => $this->person->event_attendances()->where('event_id', $event->id)->first(),
                ];

                # define pdf view
                $pdf = Pdf::loadView('pages.portal.certificates.certificate-pdf', $data);
                # setup pdf
                $pdf->setOption([
                    'defaultFont' => 'Arial',
                    'isPhpEnabled' => true,
                ]);
                # set paper of pdf
                $pdf->setPaper('letter', 'landscape');
                # generate pdf output
                $pdf = $pdf->output();
                # stream pdf
                return response()->streamDownload(
                    fn () => print($pdf),
                    "Certificado_" . trim($this->person->nuip) . "_" . trim($event->year) . ".pdf"
                );

            }
            else
                $this->dispatch('alert', title:'¡Lo sentimos!', text:'No cumples con las condiciones necesarias para acceder al certificado, por favor, comunicate con la organización del evento, al final de está página hemos dejado nuestra información de contacto, estaremos felices de atender tus peticiones, gracias', icon:'info');

        }
        else
            $this->dispatch('alert', title:'¡Uoops!', text:'Este evento aún no está terminado, por favor, espera a que el evento sea terminado para acceder a esta función', icon:'info');

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
