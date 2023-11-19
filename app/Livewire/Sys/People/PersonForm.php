<?php

namespace App\Livewire\Sys\People;

use App\Livewire\Forms\Sys\People\Frm;
use App\Models\Sys\Person;
use App\Models\User;
use App\Utils\Threads\FormThread;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class PersonForm extends Component
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
     * The Person model
     * @var Person
     */
    public Person $person;

    /**
     * The user model
     * @var User
     */
    public User $user;

    /**
     * The profile photo file
     * @var
     */
    public $profile_photo;

    /// HOOKS

    /**
     * When component is mounted
     * @return void
     */
    public function mount(): void
    {
        # set init values
        $this->person = new Person();
        $this->user = new User();
    }

    /// PRIVATE FUNCTIONS



    /// PUBLIC FUNCTIONS

    /**
     * Submit form data and save it
     * @return void
     */
    public function submit(): void
    {

        # if action is 'add' use store method of form
        if ($this->action === 'add')
        {
            $message = $this->frm->store();
            $this->dispatch('search', true, true);
        }
        # else, action is 'edit', then use update method of form
        else
        {
            $message = $this->frm->update();
            $this->dispatch('search');
        }

        # dispatch toast
        $this->dispatch('toast', title:$message);
        # close modal
        $this->open = false;

    }

    /// EVENTS

    /**
     * Open modal component and setting an action
     * @param string $action => key of action to set in the component ('add' for create new resources or 'edit' to update old resources)
     * @param Person|null $person
     * @return void
     */
    #[On('open-modal')]
    public function openModal(string $action, ?Person $person): void
    {

        # always reset Person model
        $this->person = new Person();
        # always reset User model
        $this->user = new User();
        # set action
        $this->action = $action;
        # always reset frm
        $this->frm->reset();

        # if $person is not null
        if ($action === 'edit' && $person)
        {
            # set User model
            $this->person = $person;
            $this->user = $this->person->user;
            # model in frm
            $this->frm->set_form_data($person);
        }

        # open modal
        $this->open = true;

    }

    /**
     * Render view of component
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.sys.people.person-form');
    }
}
