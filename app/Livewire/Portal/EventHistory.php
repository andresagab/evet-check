<?php

namespace App\Livewire\Portal;

use App\Models\Sys\Event;
use Livewire\Component;

class EventHistory extends Component
{
    public $events = [];

    /**
     * Mount the component and load initial data.
     */
    public function mount()
    {
        $this->events = Event::query()
        ->withCount('event_attendances')
        ->where('id', '!=', 17)
        ->orderBy('year', 'desc')
        ->get();
    }

    public function render()
    {
        return view('livewire.portal.event-history');
    }
}
