<?php

namespace App\Livewire\Sys\Events\Attendances;

use App\Models\Sys\Event;
use App\Models\Sys\EventAttendance;
use App\Utils\CommonUtils;
use App\Utils\Threads\TableThread;
use Livewire\Attributes\On;
use Livewire\Component;

class AttendancesTable extends Component
{

    /// USING
    use TableThread;

    /// PROPERTIES

    /**
     * The Event model (main resource)
     * @var Event
     */
    public Event $event;

    /**
     * The main data array
     * @var array
     */
    public $attendances = [];

    /// HOOKS

    /**
     * When component is mounted
     * @param Event $event => The event model
     * @return void
     */
    public function mount(Event $event): void
    {
        # set event model
        $this->event = $event;
    }

    /// PRIVATE FUNCTIONS



    /// PUBLIC FUNCTIONS
    /**
     * Refresh or update pagination data
     * @param array $pagination => pagination info array
     * @return void
     */
    #[On('refreshPagination')]
    public function refreshPagination(array $pagination): void
    {
        # set pagination with arguments
        $this->pagination = $pagination;
        # call to search
        $this->search();
    }


    /**
     * Search data in database
     * @param bool $count_total => true for count the total of loaded resources
     * @param bool $reset_pagination => true for reset the current pagination to 1
     * @return void
     */
    #[On('search')]
    public function search(bool $count_total = false, bool $reset_pagination = false): void
    {

        # if $reset_pagination is true
        if ($reset_pagination)
            $this->pagination['page'] = 1;

        # get offset
        $offset = CommonUtils::getOffset($this->pagination);

        # set initial query
        $query = EventAttendance::query()
            # link to events
            ->join('events as e', 'event_attendances.event_id', '=', 'e.id')
            # link to people
            ->join('people as p', 'event_attendances.person_id', '=', 'p.id')
            # filter by event_id
            ->where('event_id', $this->event->id)
            # filter by person by names, surnames or nuip
            ->where(function ($q) {
                # define $filter for current where
                $filter = "%" . mb_strtolower($this->filters['name'], 'UTF-8') . "%";
                # if filter have data
                if ($this->filters['name'] != '')
                    # filter event name
                    return $q->whereRaw('LOWER(p.names) LIKE ?', [$filter])
                        ->orWhereRaw('LOWER(p.surnames) LIKE ?', [$filter])
                        ->orWhereRaw('LOWER(p.nuip) LIKE ?', [$filter]);
                else
                    return null;
            });

        # search data in db using partial query
        $this->attendances = $query
            ->select('event_attendances.*')
            ->with(['event', 'person'])
            ->orderBy('created_at', 'DESC')
            ->limit($this->pagination['per_page'])
            ->offset($offset)
            ->get();

        # if $count_total is true
        if ($count_total)
            $this->getTotalData($query, 'utilities.data-paginator');

    }


    /**
     * Open add modal to create a new resource
     * @return void
     */
    public function openAddModal(): void
    {
        $this->dispatch('open-modal', 'add', $this->event)->to('sys.events.attendances.attendance-form');
    }

    /**
     * Open edit modal to update a resource
     * @param EventAttendance $attendance
     * @return void
     */
    public function openEditModal(EventAttendance $attendance): void
    {
        $this->dispatch('open-modal', 'edit', $this->event, $attendance)->to('sys.events.attendances.attendance-form');
    }

    /**
     * Open delete modal to remove a resource
     * @param EventAttendance $attendance
     * @return void
     */
    public function openDeleteModal(EventAttendance $attendance): void
    {
        $this->dispatch('open-modal', $attendance)->to('sys.events.attendances.attendance-delete');
    }

    /**
     * Render view of component
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.sys.events.attendances.attendances-table')
            ->layout('components.layouts.pages.sys-layout', [
                'title' => __('messages.menu.event_attendances'),
            ]);
    }
}
