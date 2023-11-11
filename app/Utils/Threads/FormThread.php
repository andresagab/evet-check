<?php

namespace App\Utils\Threads;

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

    }

    /// EVENTS

    /**
     * Open modal component and setting an action
     * @param string $action => key of action to set in the component ('add' for create new resources or 'edit' to update old resources)
     * @return void
     */
    public function openModal(string $action) : void
    {

    }

}
