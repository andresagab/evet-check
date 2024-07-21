<?php

namespace App\Livewire\Sys\Locations;

use Livewire\Component;

class Table extends Component
{

    /**
     * Render view of component
     * @return mixed
     */
    public function render()
    {
        return view('livewire.sys.locations.table')
            ->layout('components.layouts.pages.sys-layout', [
                'title' => __('messages.menu.locations'),
            ]);
    }
}
