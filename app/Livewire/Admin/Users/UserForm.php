<?php

namespace App\Livewire\Admin\Users;

use App\Livewire\Forms\Admin\Users\Frm;
use App\Models\User;
use App\Utils\Threads\FormThread;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserForm extends Component
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
     * The User model
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
    }

    /// EVENTS

    /**
     * Open modal component and setting an action
     * @param string $action => key of action to set in the component ('add' for create new resources or 'edit' to update old resources)
     * @param User|null $user
     * @return void
     */
    #[On('open-modal')]
    public function openModal(string $action, ?User $user): void
    {

        # always reset User model
        $this->user = new User();
        # set action
        $this->action = $action;
        # always reset frm
        $this->frm->reset();

        # if $user is not null
        if ($action === 'edit' && $user)
        {
            # set User model
            $this->user = $user;
            # model in frm
            #$this->frm->set_user($user);
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
        return view('livewire.admin.users.user-form');
    }
}
