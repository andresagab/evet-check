<?php

namespace App\Livewire\Portal;

use App\Models\Sys\Event;
use App\Models\Sys\EventAttendance;
use App\Models\Sys\Person;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
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



    /// PUBLIC FUNCTIONS

    /**
     * Load registered events of person
     * @return void
     */
    #[On('load-registered-events')]
    public function load_registered_events() : void
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
    }

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

    /**
     * Generate certificate of person for attendance in event
     * @param EventAttendance $attendance
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|void
     */
    public function generate_certificate(EventAttendance $attendance)
    {

        # event status validation
        if ($attendance->event->state === 'CP')
        {

            # person type and attendances validation
            if ($attendance->can_get_certificate())
            {

                # define data of view
                $data = [
                    'event' => $attendance->event,
                    'person' => $this->person,
                    'event_attendance' => $this->person->event_attendances()->where('event_id', $attendance->event->id)->first(),
                    'setup' => $attendance->event->get_certificate_setup(),
                ];

                # define pdf from dompdf.wrapper
                $pdf = app('dompdf.wrapper');

                # define pdf view
                $pdf->loadView('pages.portal.certificates.certificate-pdf', $data);
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
                    "Certificado_" . trim($this->person->nuip) . "_" . trim($attendance->event->year) . ".pdf"
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
     * Open the register event attendance modal
     * @return void
     */
    public function open_register_event_attendance_modal() : void
    {
        $this->dispatch('open-modal', $this->person)->to('portal.register-event-attendance');
    }


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
