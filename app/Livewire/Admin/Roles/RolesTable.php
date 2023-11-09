<?php

namespace App\Livewire\Admin\Roles;

use App\Models\Role;
use App\Utils\CommonUtils;
use App\Utils\Threads\TableThread;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class RolesTable extends Component
{

    /// THREADS
    use TableThread;

    /// PROPERTIES

    /**
     * The main data array
     * @var array
     */
    public $roles = [];

    /**
     * The listeners of component
     * @var string[]
     */
    protected $listeners = ['search', 'refreshPagination'];

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
     * @return void
     */
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
    public function search(bool $count_total = false, bool $reset_pagination = false): void
    {

        # if $reset_pagination is true
        if ($reset_pagination)
            $this->pagination['page'] = 1;

        # get offset
        $offset = CommonUtils::getOffset($this->pagination);

        # set initial query
        $query = Role::query()
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
        $this->roles = $query
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
        #$this->emit
    }

    /**
     * Open edit modal to update a resource
     * @return void
     */
    public function openEditModal(): void
    {
    }

    /**
     * Open delete modal to remove a resource
     * @return void
     */
    public function openDeleteModal(): void
    {
    }

    /// EVENTS


    /**
     * Render view of component
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.admin.roles.roles-table');
    }
}
