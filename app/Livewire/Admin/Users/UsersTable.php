<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Utils\CommonUtils;
use App\Utils\Threads\TableThread;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Component;

class UsersTable extends Component
{

    /// USING
    use TableThread;

    /// PROPERTIES

    /**
     * The main data array
     * @var array
     */
    public $users = [];

    /// HOOKS
    /**
     * When component is mounted
     * @return void
     */
    public function mount(): void
    {
        # add new filters
        $this->filters['code'] = '';
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
        $query = User::query()
            # filter by name or display_name
            ->where(function ($q) {
                # if $this->filters['name'] have data
                if ($this->filters['name'] != '')
                    # filter by name
                    return $q->whereRaw('LOWER(name) LIKE ?', ["%" . mb_strtolower($this->filters['name'], 'UTF-8') . "%"]);
                else
                    return null;
            })
            ->where(function ($q) {
                # if $this->filters['code'] have data
                if ($this->filters['code'] != '')
                    # filter by code
                    return $q->whereRaw('LOWER(code) LIKE ?', ["%" . mb_strtolower($this->filters['code'], 'UTF-8') . "%"]);
            });

        # search data in db using partial query
        $this->users = $query
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
        $this->dispatch('open-modal', 'add')->to('admin.users.user-form');
    }

    /**
     * Open edit modal to update a resource
     * @param User $user
     * @return void
     */
    public function openEditModal(User $user): void
    {
        $this->dispatch('open-modal', 'edit', $user)->to('admin.users.user-form');
    }

    /**
     * Open delete modal to remove a resource
     * @param User $user
     * @return void
     */
    public function openDeleteModal(User $user): void
    {
        $this->dispatch('open-modal', $user)->to('admin.users.user-delete');
    }

    /**
     * Open delete modal to remove a resource
     * @param User $user => the model resource
     * @return void
     */
    public function open_manage_role_permissions(User $user): void
    {
        $this->dispatch('open-modal', $user)->to('admin.users.manage-user-permissions');
    }

    /// EVENTS

    /**
     * Render view of component
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.admin.users.users-table');
    }
}
