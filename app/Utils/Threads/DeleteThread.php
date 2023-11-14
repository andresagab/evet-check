<?php

namespace App\Utils\Threads;

/**
 * Trait for form component's
 */
trait DeleteThread
{

    /// PROPERTIES

    /**
     * The modal state
     * @var bool
     */
    public bool $open = false;

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

    /**
     * Dispatch try catch exception or get the error message
     * @param \Exception $exception => the generated Exception
     * @param bool $return_message => true to get error message, false to dispatch a toast
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|\Illuminate\Foundation\Application|string|void|null
     */
    private function dispatch_try_catch(\Exception $exception, bool $return_message = false)
    {
        # dispatch toast
        $message = __('messages.errors.try_error', ['code' => $exception->getCode()]);
        # log error
        error_log("Error => " . $exception->getMessage());

        # if $return_message is true, return this
        if ($return_message)
            return $message;
        # else, dispatch in toast
        else
            $this->dispatch('toast', title:$message, icon:'error');

    }

    /// PUBLIC FUNCTIONS

    /**
     * Delete a resource
     * @return void
     */
    public function delete() : void
    {

    }

    /// EVENTS

    /**
     * Open modal component and setup to delete
     * @return void
     */
    public function open_modal() : void
    {

    }

}
