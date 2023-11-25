<?php

namespace App\Livewire\Sys\Activities\Attendances;

use Livewire\Component;
use App\Models\Sys\Activity;
use App\Models\Sys\ActivityAttendance;
use App\Utils\CommonUtils;
use App\Utils\Threads\TableThread;
use Illuminate\Notifications\Action;
use Livewire\Attributes\On;


class AttendanceTable extends Component
{
    /// USING
    use TableThread;

    /**
     * The activity model 
     * @var Activity
     */
    public Activity $activity;

    /**
     * The main data array
     * @var array
     */
    public $attendances = [];

    /// HOOKS

    /**
     * When component is mounted
     * @param Activity $activity => The e¿activity model
     * @return void
     */
    public function mount(Activity $activity): void
    {
        # set activity model
        $this->activity = $activity;
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
        $query = ActivityAttendance::query()
            # link to activity
            ->join('activities as a', 'activity_attendances.activity_id', '=', 'a.id')
            # link to people
            ->join('people as p', 'activity_attendances.person_id', '=', 'p.id')
            # filter by activity_id
            ->where('activity_id', $this->activity->id)
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
            ->select('activity_attendances.*')
            ->with(['activity', 'person'])
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
        $this->dispatch('open-modal', 'add', $this->activity)->to('sys.activities.attendances.attendance-form');
    }

    /**
     * Open edit modal to update a resource
     * @param ActivityAttendance $attendance
     * @return void
     */
    public function openEditModal(ActivityAttendance $attendance): void
    {
        $this->dispatch('open-modal', 'edit', $this->activity, $attendance)->to('sys.activities.attendances.attendance-form');
    }

    /**
     * Open delete modal to remove a resource
     * @param ActivityAttendance $attendance
     * @return void
     */
    public function openDeleteModal(ActivityAttendance $attendance): void
    {
        $this->dispatch('open-modal', $attendance)->to('sys.activities.attendances.attendance-delete');
    }

    
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
