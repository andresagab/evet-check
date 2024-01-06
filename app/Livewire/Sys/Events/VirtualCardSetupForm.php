<?php

namespace App\Livewire\Sys\Events;

use App\Models\Sys\Event;
use App\Utils\Threads\FormThread;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class VirtualCardSetupForm extends Component
{

    /// USING
    use FormThread;

    /// PROPERTIES

    /**
     * The Event model
     * @var Event
     */
    public Event $event;

    /**
     * The form data
     * @var array|string[]
     */
    public array $frm = [
        'person_names_margin_top' => '',
        'person_names_margin_x' => '',
        'attendance_type_margin_top' => '',
        'attendance_type_margin_x' => '',
        'dni_margin_top' => '',
        'dni_margin_x' => '',
        'bar_code_position' => 'bottom',
        'bar_code_margin_top' => '',
        'bar_code_margin_bottom' => '',
        'bar_code_margin_left' => '',
        'bar_code_margin_right' => '',
        'font_size' => '',
        'text_color' => '#000',
        'attendance_type_text_color' => '#000',
        'background_opacity' => '1',
    ];


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

    /**
     * The validation rules of form
     * @return string[]
     */
    public function rules()
    {
        $rules = [
            'frm.person_names_margin_top' => 'required|numeric|min:1',
            'frm.person_names_margin_x' => 'required|numeric|min:1',
            'frm.dni_margin_top' => 'required|numeric|min:1',
            'frm.dni_margin_x' => 'required|numeric|min:1',
            'frm.attendance_type_margin_top' => 'required|numeric|min:1',
            'frm.attendance_type_margin_x' => 'required|numeric|min:1',
            'frm.bar_code_position' => 'required',
            'frm.bar_code_margin_top' => 'required_if:frm.bar_code_position,"custom"|numeric|min:1',
            'frm.bar_code_margin_bottom' => 'required_if:frm.bar_code_position,"custom"|numeric|min:1',
            'frm.bar_code_margin_left' => 'required_if:frm.bar_code_position,"custom"|numeric|min:1',
            'frm.bar_code_margin_right' => 'required_if:frm.bar_code_position,"custom"|numeric|min:1',
            'frm.font_size' => 'required|numeric|min:1',
            'frm.text_color' => 'required|string',
            'frm.attendance_type_text_color' => 'required|string',
            'frm.background_opacity' => 'required|numeric|min:0.1',
        ];

        return $rules;
    }

    /**
     * When form is submitted
     * @return void
     */
    public function submit() : void
    {

        # check user session
        if (Auth::check())
        {

            # validate form data
            $this->validate();

            # load event from db
            $event = Event::query()->find($this->event->id);
            # if event was fund
            if (!empty($event))
            {
                # set certificate_setup attribute
                $event->virtual_card_setup = $this->frm;

                # use try catch to save changes
                try {
                    # if was not updated, then dispatch not saved message
                    if (!$event->update())
                        $this->dispatch('toast', title:__('messages.responses.not_saved'), icon:'error');
                    # else, then emit success message
                    else
                        $this->dispatch('toast', title:__('messages.responses.saved'), icon:'success');
                    # always dispatch to search table data
                    $this->dispatch('search');
                }
                catch (\Exception $e)
                {
                    # dispatch toast
                    $this->dispatch('toast', title:__('messages.errors.try_error', ['code' => $e->getCode()]), icon:'error');
                    # log error
                    error_log("Error => " . $e->getMessage());
                }

            }

        }

    }

    /// EVENTS

    /**
     * Open modal component and setting an action
     * @param string $action => key of action to set in the component ('add' for create new resources or 'edit' to update old resources)
     * @param Event|null $event
     * @return void
     */
    #[On('open-modal')]
    public function openModal(Event $event): void
    {

        # always reset Event model
        $this->event = new Event();
        # always reset frm
        $this->reset(['frm']);

        # if $event is not null
        if ($event)
        {
            # set User model
            $this->event = $event;

            # load setup from model
            $setup = $this->event->get_virtual_card_setup();
            # if setup have data
            if (count($setup) > 0)
                $this->frm = $setup;

            # open modal
            $this->open = true;
        }

    }

    /**
     * Render view of component
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.sys.events.virtual-card-setup-form');
    }
}
