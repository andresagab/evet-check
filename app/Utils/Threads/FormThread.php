<?php

namespace App\Utils\Threads;

use Livewire\Attributes\On;

/**
 * Trait for form component's
 */
trait FormThread
{

    /// PROPERTIES

    /**
     * The modal state
     * @var bool
     */
    public bool $open = false;

    /**
     * The action of modal
     * @var string
     */
    public string $action = 'add';

    /// CONST

    /// HOOKS

    /**
     * When component is mounted
     * @return void
     */
    public function mount() : void
    {

    }

    /// PRIVATE FUNCTIONS

    /// PUBLIC FUNCTIONS

    /**
     * Submit form data and save it
     * @return void
     */
    public function submit() : void
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
     * @return void
     */
    #[On('open-modal')]
    public function openModal(string $action) : void
    {

    }

}
