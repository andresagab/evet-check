<?php

namespace App\Livewire\Admin\Roles;

use App\Livewire\Forms\Admin\Roles\Frm;
use App\Models\Role;
use App\Utils\Threads\FormThread;
use Livewire\Attributes\On;
use Livewire\Component;

class RoleForm extends Component
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
     * The main resource model
     * @prop Role
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
     * @param Role $role => The model resource
     * @return void
     */
    #[On('open-modal')]
    public function openModal(string $action, Role $role): void
    {

        # always reset main model resource value
        $this->role = new Role();
        # set action
        $this->action = $action;
        # always reset frm
        $this->frm->reset();

        # if action is 'edit' and received model have data
        if ($action === 'edit' && $role->id)
        {
            # set main model resource with argument
            $this->role = $role->refresh();
            $this->frm->set_role($this->role);
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
        return view('livewire.admin.roles.role-form');
    }
}
