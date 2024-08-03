<?php

namespace App\Livewire\Sys\Locations;

use App\Models\Sys\Location;
use App\Utils\CommonUtils;
use App\Utils\Threads\TableThread;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{

    /// USING
    use TableThread;

    /// PROPERTIES

    /**
     * The main data array
     * @var array
     */
    public $locations = [];

    /// HOOKS
    /**
     * When component is mounted
     * @return void
     */
    public function mount(): void
    {
        # add filters
        $this->filters['active'] = 'all';
    }

    /// PRIVATE FUNCTIONS



    /// PUBLIC FUNCTIONS

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
        $query = Location::query()
            # filter by location name
            ->where(function ($q) {
                # define $filter for current where
                $filter = "%" . mb_strtolower($this->filters['name'], 'UTF-8') . "%";
                # if filter have data
                if ($this->filters['name'] != '')
                    # filter by event name
                    return $q->whereRaw('LOWER(name) LIKE ?', [$filter]);
                else
                    return null;
            })
            # filter by active
            ->where(function ($q) {
                if ($this->filters['active'] != 'all')
                    return $q->where('active', $this->filters['active']);
                else
                    return null;
            });

        # search data in db using partial query
        $this->locations = $query
            ->select('locations.*')
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
        $this->dispatch('open-modal', 'add')->to('sys.locations.form');
    }

    /**
     * Open edit modal to update a resource
     * @param Location $location
     * @return void
     */
    public function openEditModal(Location $location): void
    {
        $this->dispatch('open-modal', 'edit', $location)->to('sys.locations.form');
    }

    /**
     * Open delete modal to remove a resource
     * @param Location $location
     * @return void
     */
    public function openDeleteModal(Location $location): void
    {
        $this->dispatch('open-modal', $location)->to('sys.locations.delete');
    }

    /**
     * Render view of component
     * @return mixed
     */
    public function render()
    {
        return view('livewire.sys.locations.table')
            ->layout('components.layouts.pages.sys-layout', [
                'title' => __('messages.menu.locations'),
            ]);
    }
}
