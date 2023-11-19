<?php

namespace App\Livewire\Admin\Permissions;

use App\Models\Permission;
use App\Utils\Threads\DeleteThread;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class PermissionDelete extends Component
{
   /// USING

   use DeleteThread;

   /// PROPERTIES

   /**
    * The main model resource
    * @var Permission
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
               $permission = Permission::query()->find($this->permission->id);

               # if resource was deleted, dispatch success toast
               if ($permission->delete())
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
    * @param Permission $permission => A model resource
    * @return void
    */
   #[On('open-modal')]
   public function open_modal(Permission $permission): void
   {

       # always refresh model value
       $this->permission = new Permission();
       # if model is not null
       if ($permission)
       {
           # set model value
           $this->permission = $permission->refresh();
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
    public function render()
    {
        return view('livewire.admin.permissions.permission-delete');
    }
}
