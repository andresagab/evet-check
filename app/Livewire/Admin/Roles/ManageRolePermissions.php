<?php

namespace App\Livewire\Admin\Roles;

use App\Models\Role;
use App\Utils\Threads\DeleteThread;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ManageRolePermissions extends Component
{

    /// USING
    use DeleteThread;


    /// PROPERTIES

    /**
     * The Role model
     * @var Role
     */
    public Role $role;

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
        $this->role = new Role();
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

                # load role from db
                #$role = Role::query()->find($this->role);

                # sync permissions of role
                $this->role->syncPermissions($this->permissions);
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
     * Open modal component and setup to manage permissions of role
     * @param Role $role
     * @return void
     */
    #[On('open-modal')]
    public function open_modal(Role $role): void
    {
        # always reset Role model and permissions
        $this->role = new Role();
        $this->reset(['permissions']);

        # if $role have id
        if ($role->id)
        {
            # set role model
            $this->role = $role->refresh();
            # load permission of role
            $this->permissions = $this->role->permissions()->pluck('id')->toArray();
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
        return view('livewire.admin.roles.manage-role-permissions');
    }
}
