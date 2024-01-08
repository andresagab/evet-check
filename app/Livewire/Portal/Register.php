<?php

namespace App\Livewire\Portal;

use App\Livewire\Forms\Sys\People\Frm;
use App\Models\Sys\Person;
use App\Models\User;
use App\Utils\Threads\FormThread;
use Livewire\Attributes\On;
use Livewire\Component;

class Register extends Component
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

        # explode names and surnames of person
        $names = explode(' ', $this->frm->names);
        $surnames = explode(' ', $this->frm->surnames);

        # set username with first name and first surname of person
        $this->frm->name = "$names[0] $surnames[0]";
        # set user form data
        $this->person->nuip = $this->frm->code = $this->frm->nuip;
        $this->frm->state = "A";
        $this->frm->role_name = "assistant";
        $this->frm->password = mb_strtoupper($names[0][0]) . $this->frm->nuip;
        $this->frm->password_confirmation = $this->frm->password;
        # store form data and set message with response
        $message = $this->frm->store();

        # search saved person
        $person = Person::query()->where('nuip', $this->person->nuip)->first();

        # dispatch toast
        $this->dispatch('toast', title:$message);

        # if person was saved
        if ($message === __('messages.responses.saved') && !empty($person))
        {
            # sleep by 1.5 seconds
            sleep(1.5);
            # redirect to dashboard
            $this->redirectRoute('portal.dashboard', $person, navigate: true);
        }

    }

    /// EVENTS

    /**
     * Open modal component and setting an action
     * @return void
     */
    #[On('open-modal')]
    public function openModal(): void
    {

        # always reset Person model
        $this->person = new Person();
        # always reset User model
        $this->user = new User();
        # always reset frm
        $this->frm->reset();

        # open modal
        $this->open = true;

    }

    /**
     * Render view of component
     * @return mixed
     */
    public function render()
    {
        return view('livewire.portal.register');
    }
}
