<?php

namespace App\Livewire\Sys\People;

use App\Models\Sys\Person;
use App\Models\User;
use App\Utils\CommonUtils;
use App\Utils\Threads\TableThread;
use Livewire\Attributes\On;
use Livewire\Component;

class PeopleTable extends Component
{

    /// USING
    use TableThread;

    /// PROPERTIES

    /**
     * The main data array
     * @var array
     */
    public $people = [];

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
        $query = Person::query()
            # filter by person, name, surnames or nuip
            ->where(function ($q) {
                # define $filter for current where
                $filter = "%" . mb_strtolower($this->filters['name'], 'UTF-8') . "%";
                # if $this->filters['name'] have data
                if ($this->filters['name'] != '')
                    # filter by names, surnames or nuip
                    return $q->whereRaw('LOWER(names) LIKE ?', [$filter])
                        ->orWhereRaw('LOWER(surnames) LIKE ?', [$filter])
                        ->orWhereRaw('LOWER(nuip) LIKE ?', [$filter]);
                else
                    return null;
            });

        # search data in db using partial query
        $this->people = $query
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
        $this->dispatch('open-modal', 'add')->to('sys.people.person-form');
    }

    /**
     * Open edit modal to update a resource
     * @param Person $person
     * @return void
     */
    public function openEditModal(Person $person): void
    {
        $this->dispatch('open-modal', 'edit', $person)->to('sys.people.person-form');
    }

    /**
     * Open delete modal to remove a resource
     * @param Person $person
     * @return void
     */
    public function openDeleteModal(Person $person): void
    {
        $this->dispatch('open-modal', $person)->to('sys.people.person-delete');
    }

    /**
     * Open delete modal to remove a resource
     * @param User $user => The model resource
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
        return view('livewire.sys.people.people-table')
            ->layout('components.layouts.pages.sys-layout', [
                'title' => __('messages.menu.people'),
            ]);
    }
}
