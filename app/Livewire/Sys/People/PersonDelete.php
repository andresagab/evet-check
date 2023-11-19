<?php

namespace App\Livewire\Sys\People;

use App\Http\Controllers\admin\UserController;
use App\Models\Sys\Person;
use App\Models\User;
use App\Utils\Threads\DeleteThread;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class PersonDelete extends Component
{

    /// USING

    use DeleteThread;

    /// PROPERTIES

    /**
     * The main model resource
     * @var Person
     */
    public Person $person;

    /// HOOKS

    /**
     * When component is mounted
     * @return void
     */
    public function mount(): void
    {
        # init default values
        $this->person = new Person();
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

            # use try
            try {

                # load Person from db
                $person = Person::query()->find($this->person->id);

                # if person was fund
                if ($person)
                {

                    # load resource from db
                    $user = User::query()->find($person->user->id);

                    # if person was deleted
                    if ($person->delete())
                    {

                        # reset Person model
                        $this->person = new Person();

                        # delete user data with controller and get result
                        $result = UserController::delete($user);

                        # dispatch message
                        $this->dispatch('toast', title:$result['message'], icon:$result['icon']);
                        # dispatch to load data
                        $this->dispatch('search', true, false);

                    }
                    # else, dispatch toast with not deleted message
                    else
                        $this->dispatch('toast', title:__('messages.responses.not_deleted'), icon:'warning');

                    # close modal
                    $this->open = false;

                }
                # else, dispatch toast with record not loaded message
                else
                    $this->dispatch('toast', title:__('messages.responses.record_not_loaded'), icon:'warning');


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
    public function open_modal(Person $person): void
    {

        # always refresh model value
        $this->person = new Person();
        # if model is not null
        if ($person)
        {
            # set model value
            $this->person = $person;
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
        return view('livewire.sys.people.person-delete');
    }
}
