<?php

namespace App\Livewire\Admin\Users;

use App\Http\Controllers\admin\UserController;
use App\Models\User;
use App\Utils\Threads\DeleteThread;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class UserDelete extends Component
{

    /// USING

    use DeleteThread;

    /// PROPERTIES

    /**
     * The main model resource
     * @var User
     */
    public User $user;

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
                $user = User::query()->find($this->user->id);

                # delete user data with controller and get result
                $result = UserController::delete($user);

                # dispatch message
                $this->dispatch('toast', title:$result['message'], icon:$result['icon']);
                # dispatch to load data
                $this->dispatch('search', true, false);
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
     * @param User $user => the model resource
     * @return void
     */
    #[On('open-modal')]
    public function open_modal(User $user): void
    {

        # always refresh model value
        $this->user = new user();
        # if model is not null
        if ($user)
        {
            # set model value
            $this->user = $user->refresh();
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
     * Render view of component
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.admin.users.user-delete');
    }
}
