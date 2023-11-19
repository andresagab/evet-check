<?php

namespace App\Livewire\Admin\Permissions;

use App\Livewire\Forms\Admin\Permissions\Frm;
use App\Models\Permission;
use App\Utils\Threads\FormThread;
use Livewire\Attributes\On;
use Livewire\Component;

class PermissionForm extends Component
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
   public Permission $permission;

   /// HOOKS

    /**
     * When component is mounted
     * @return void
     */
    public function mount(): void
    {
        # init default values
        $this->permission = new Permission();
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
     * @param permission $permission => The model resource
     * @return void
     */
    #[On('open-modal')]
    public function openModal(string $action, Permission $permission): void
    {

         # always reset main model resource value
         $this->permission = new Permission();
         # set action
         $this->action = $action;
         # always reset frm
         $this->frm->reset();
 
         # if action is 'edit' and received model have data
         if ($action === 'edit' && $permission->id)
         {
             # set main model resource with argument
             $this->permission = $permission->refresh();
             $this->frm->set_permission($this->permission);
         }
 
         # open modal
         $this->open = true;

        

    }

    /**
     * Render view of component
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.admin.permissions.permission-form');
    }
}
