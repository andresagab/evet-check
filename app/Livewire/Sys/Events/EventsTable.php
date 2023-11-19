<?php

namespace App\Livewire\Sys\Events;

use App\Models\Sys\Event;
use App\Utils\CommonUtils;
use App\Utils\Threads\TableThread;
use Livewire\Attributes\On;
use Livewire\Component;

class EventsTable extends Component
{

    /// USING
    use TableThread;

    /// PROPERTIES

    /**
     * The main data array
     * @var array
     */
    public $events = [];

    /// HOOKS
    /**
     * When component is mounted
     * @return void
     */
    public function mount(): void
    {

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
        $query = Event::query()
            # filter by person, name, surnames or nuip
            ->where(function ($q) {
                # define $filter for current where
                $filter = "%" . mb_strtolower($this->filters['name'], 'UTF-8') . "%";
                # if $this->filters['name'] have data
                if ($this->filters['name'] != '')
                    # filter by names, surnames or nuip
                    return $q->whereRaw('LOWER(name) LIKE ?', [$filter]);
                else
                    return null;
            });

        # search data in db using partial query
        $this->events = $query
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
        $this->dispatch('open-modal', 'add')->to('sys.events.event-form');
    }

    /**
     * Open edit modal to update a resource
     * @param Event $event
     * @return void
     */
    public function openEditModal(Event $event): void
    {
        $this->dispatch('open-modal', 'edit', $event)->to('sys.events.event-form');
    }

    /**
     * Open delete modal to remove a resource
     * @param Event $event
     * @return void
     */
    public function openDeleteModal(Event $event): void
    {
        $this->dispatch('open-modal', $event)->to('sys.events.event-delete');
    }

    /**
     * Render view of component
     * @return \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.sys.events.events-table')
            ->layout('components.layouts.pages.sys-layout', [
                'title' => __('messages.menu.events'),
            ]);
    }
}
