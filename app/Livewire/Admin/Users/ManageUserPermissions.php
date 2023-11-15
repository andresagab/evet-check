<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Utils\Threads\DeleteThread;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ManageUserPermissions extends Component
{

    /// USING
    use DeleteThread;


    /// PROPERTIES

    /**
     * The user model
     * @var User
     */
    public User $user;

    /**
     * Array of selected or saved permissions
     * @var array
     */
    public array $permissions = [];

    /// HOOKS

    /**
     * When component is mounted
     * @return void
     */
    public function mount(): void
    {
        # init default values
        $this->user = new User();
    }

    /// PRIVATE FUNCTIONS



    /// PUBLIC FUNCTIONS

    /**
     * save the selected permissions
     * @return void
     */
    public function save() : void
    {
        # check auth of signed user
        if (Auth::check())
        {

            # use try
            try {

                # sync permissions of user
                $this->user->syncPermissions($this->permissions);
                # dispatch toast message
                $this->dispatch('toast', title:__('messages.responses.saved'));
                # dispatch up to reload data
                $this->dispatch('search');
            }
            catch (\Exception $e)
            {
                $this->dispatch_try_catch($e);
            }

        }
    }

    /**
     * Open modal component and setup to manage permissions of user
     * @param User $user
     * @return void
     */
    #[On('open-modal')]
    public function open_modal(User $user): void
    {
        # always reset user model and permissions
        $this->user = new user();
        $this->reset(['permissions']);

        # if $user have id
        if ($user->id)
        {
            # set user model
            $this->user = $user->refresh();
            # load permission of user
            $this->permissions = $this->user->permissions()->pluck('id')->toArray();
            # open modal
            $this->open = true;
        }
        else
        {
            # close modal
            $this->open = false;
            # emit toast error message
            $this->dispatch('toast', __('messages.error.record_not_loaded'), 'warning');
        }

    }

    /// EVENTS

    /**
     * Render view of component
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.admin.users.manage-user-permissions');
    }
}
