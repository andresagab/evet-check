<?php

namespace App\Livewire\Sys\Activities\Attendances;

use Livewire\Component;

class AttendanceTable extends Component
{
    
    /**
     * Return view of component
     * @return mixed
     */
    public function render(): mixed
    {
        return view('livewire.sys.activities.attendances.attendance-table')
            ->layout('components.layouts.pages.sys-layout', [
                'title' => __('messages.menu.activity_attendances'),
            ]);
    }
}
