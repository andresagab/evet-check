<?php

namespace App\Livewire\Admin\Roles;

use App\Models\Role;
use App\Utils\Threads\DeleteThread;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class RoleDelete extends Component
{

    /// USING

    use DeleteThread;

    /// PROPERTIES

    /**
     * The main model resource
     * @var Role
     */
    public Role $role;

    /// HOOKS

    /**
     * When component is mounted
     * @return void
     */
    public function mount(): void
    {
        # init default values
        $this->role = new Role();
    }

    /// PRIVATE FUNCTIONS



    /// PUBLIC FUNCTIONS

    /**
     * Delete a resource
     * @return void
     */
    public function delete(): void
    {

        # if user is signed
        if (Auth::check())
        {

            try {

                # load resource from db
                $role = Role::query()->find($this->role->id);

                # if resource was deleted, dispatch success toast
                if ($role->delete())
                {
                    # dispatch message
                    $this->dispatch('toast', title:__('messages.responses.deleted'));
                    # dispatch to load data
                    $this->dispatch('search', true, false);
                }
                # else, emit not deleted message
                else
                    $this->dispatch('toast', title:__('messages.errors.not_deleted'), icon:'warning');

                # close modal
                $this->open = false;
            }
            catch (\Exception $e)
            {
                $this->dispatch_try_catch($e);
            }

        }

    }

    /// EVENTS

    /**
     * Open modal component and setup to delete
     * @param Role $role => A model resource
     * @return void
     */
    #[On('open-modal')]
    public function open_modal(Role $role): void
    {

        # always refresh model value
        $this->role = new Role();
        # if model is not null
        if ($role)
        {
            # set model value
            $this->role = $role->refresh();
            # open modal
            $this->open = true;
        }
        # else
        else
        {
            # close modal
            $this->open = false;
            # emit toast error message
            $this->dispatch('toast', __('messages.error.record_not_loaded'), 'warning');
        }

    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.admin.roles.role-delete');
    }
}
