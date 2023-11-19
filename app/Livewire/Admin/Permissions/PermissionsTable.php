<?php

namespace App\Livewire\Admin\Permissions;

use App\Models\Permission;
use App\Utils\CommonUtils;
use App\Utils\Threads\TableThread;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Component;


class PermissionsTable extends Component
{
    /// THREADS
    use TableThread;

     /// PROPERTIES

     /**
     * The main data array
     * @var array
     */
    public $permissions = [];


    /**
     * The pagination info array
     * @var array|int[]
     */
    public array $pagination = CommonUtils::PAGINATION_INFO;

    /**
     * The array with common filters
     * @var array
     */
    public array $filters = [
        'name' => '',
        'dates' => [
            'begin_created_at' => '',
            'end_created_at' => '',
        ],
    ];

    /**
     * The DateTime object
     * @var \DateTime
     */
    public \DateTime $dateTime;

    /// CONST

    /// HOOKS

    /**
     * When component is mounted
     * @return void
     */
    public function mount() : void
    {
        # set init or default values
        $this->dateTime = new \DateTime('now');
        # set filters at end date
        $this->filters['dates']['end_date'] = $this->dateTime->format('Y-m-d');
    }

    /// PRIVATE FUNCTIONS

    /// PUBLIC FUNCTIONS

    /**
     * Refresh or update pagination data
     * @param array $pagination => pagination info array
     * @param callable $callback => function to be called after set pagination
     * @return void
     */
    #[On('refreshPagination')]
    public function refreshPagination(array $pagination) : void
    {
        # refresh pagination
        $this->pagination = $pagination;
        # execute callback
        $this->search();
    }

    /**
     * Search data in database
     * @param bool $count_total => true for count the total of loaded resources
     * @param bool $reset_pagination => true for reset the current pagination to 1
     * @return void
     */
    #[On('search')]
    public function search(bool $count_total = false, bool $reset_pagination = false) : void
    {
        # if $reset_pagination is true
        if ($reset_pagination)
            $this->pagination['page'] = 1;

        # get offset
        $offset = CommonUtils::getOffset($this->pagination);

        # set initial query
        $query = Permission::query()
            # filter by name or display_name
            ->where(function ($q) {
                # if $this->filters['name'] have data
                if ($this->filters['name'] != '')
                    # filter by name
                    return $q->whereRaw('LOWER(name) LIKE ?', ["%" . mb_strtolower($this->filters['name'], 'UTF-8') . "%"])
                        # or by display_name
                        ->orWhereRaw('LOWER(display_name) LIKE ?', ["%" . mb_strtolower($this->filters['name'], 'UTF-8') . "%"]);
                else
                    return null;
            });

        # search data in db using partial query
        $this->permissions = $query
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
    public function openAddModal() : void
    {
        $this->dispatch('open-modal', 'add')->to('admin.permissions.permission-form');
    }

    /**
     * Open edit modal to update a resource
     * @return void
     */
    public function openEditModal(Permission $permission) : void
    {
        $this->dispatch('open-modal', 'edit', $permission)->to('admin.permissions.permission-form');
    }

    /**
     * Open delete modal to remove a resource
     * @return void
     */
    public function openDeleteModal(Permission $permission) : void
    {
        $this->dispatch('open-modal', $permission)->to('admin.permissions.permission-delete');
    }


    /// STATIC FUNCTIONS


    /// EVENTS


    /**
     * Render view of component
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.admin.permissions.permissions-table');
    }
}




   


