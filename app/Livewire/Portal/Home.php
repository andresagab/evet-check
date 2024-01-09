<?php

namespace App\Livewire\Portal;

use App\Models\Sys\Person;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Home extends Component
{

    /// USING



    /// PROPERTIES

    /**
     * The dni attribute
     * @var string
     */
    #[Rule('required|max:20')]
    public $dni = '';

    /// HOOKS

    /**
     * When component is mounted
     * @return void
     */
    public function mount() : void
    {
    }

    /// PRIVATE FUNCTIONS



    /// PUBLIC FUNCTIONS

    /**
     * Search person and redirect to dashboard
     * @return void
     */
    public function search_person() : void
    {

        # validate form
        $this->validate();

        # search person in db
        $person = Person::query()->where('nuip', $this->dni)->first();
        # if person was fund
        if (!empty($person))
        {
            # redirect to dashboard
            $this->redirectRoute('portal.dashboard', $person, navigate:true);
        }
        else
        {
            $this->dispatch('alert', title:'Lo sentimos', text:"El número de identificación '$this->dni' no está registrado, por favor comunicate con los organizadores del evento, gracias.", icon:'warning');
        }

    }

    /// EVENTS

    /**
     * Open the register modal
     * @return void
     */
    public function open_register_modal() : void
    {
        $this->dispatch('open-modal')->to('portal.register');
    }


    /**
     * Render view of component
     * @return mixed
     */
    public function render(): mixed
    {
        return view('livewire.portal.home')
            ->layout('components.layouts.pages.base-layout', [
                'tabTitle' => 'Portal de asistencia',
            ]);
    }
}
