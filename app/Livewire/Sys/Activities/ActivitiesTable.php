<?php

namespace App\Livewire\Sys\Activities;

use App\Models\Sys\Activity;
use App\Utils\CommonUtils;
use App\Utils\Threads\TableThread;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.pages.sys-layout')]
class ActivitiesTable extends Component
{

    /// USING
    use TableThread;

    /// PROPERTIES

    /**
     * The main data array
     * @var array
     */
    public $activities = [];

    /// HOOKS
    /**
     * When component is mounted
     * @return void
     */
    public function mount(): void
    {
        # add filters
        $this->filters['event_name'] = '';
        $this->filters['author_name'] = '';
        $this->filters['date'] = '';
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
        $query = Activity::query()
            # link to events
            ->join('events as e', 'activities.event_id', '=', 'e.id')
            # filter by event name
            ->where(function ($q) {
                # define $filter for current where
                $filter = "%" . mb_strtolower($this->filters['event_name'], 'UTF-8') . "%";
                # if filter have data
                if ($this->filters['event_name'] != '')
                    # filter by event name
                    return $q->whereRaw('LOWER(e.name) LIKE ?', [$filter]);
                else
                    return null;
            })
            # filter by author name
            ->where(function ($q) {
                # define $filter for current where
                $filter = "%" . mb_strtolower($this->filters['author_name'], 'UTF-8') . "%";
                # if filter have data
                if ($this->filters['author_name'] != '')
                    # filter by author_name
                    return $q->whereRaw('LOWER(author_name) LIKE ?', [$filter]);
                else
                    return null;
            })
            # filter by activity name
            ->where(function ($q) {
                # define $filter for current where
                $filter = "%" . mb_strtolower($this->filters['name'], 'UTF-8') . "%";
                # if filter have data
                if ($this->filters['name'] != '')
                    # filter by author_name
                    return $q->whereRaw('LOWER(activities.name) LIKE ?', [$filter]);
                else
                    return null;
            });

        # search data in db using partial query
        $this->activities = $query
            ->select('activities.*')
            ->with(['event'])
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
        $this->dispatch('open-modal', 'add')->to('sys.activities.activity-form');
    }

    /**
     * Open edit modal to update a resource
     * @param Activity $activity
     * @return void
     */
    public function openEditModal($id): void
    {
        $activity = Activity::find($id);
        $this->dispatch('open-modal', 'edit', $activity)->to('sys.activities.activity-form');
    }

    /**
     * Open delete modal to remove a resource
     * @param Activity $activity
     * @return void
     */
    public function openDeleteModal($id): void
    {
        $activity = Activity::find($id);
        $this->dispatch('open-modal', $activity)->to('sys.activities.activity-delete');
    }

    /**
     * Open register attendance modal
     * @param Activity $activity
     * @return void
     */
    public function open_register_attendance_modal($id): void
    {
        $activity = Activity::find($id);
        $this->dispatch('open-modal', $activity)->to('sys.activities.register_attendance');
    }

    /**
     * Set layout data
     * @return array
     */
    public function layoutData(): array
    {
        return [
            'title' => __('messages.menu.activities'),
        ];
    }

    /**
     * Render view of component
     * @return \Illuminate\View\View
     */
    #[Title('Actividades')]
    public function render(): View
    {
        return view('livewire.sys.activities.activities-table');
    }
}
