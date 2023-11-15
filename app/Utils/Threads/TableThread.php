<?php

namespace App\Utils\Threads;

use App\Utils\CommonUtils;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;

/**
 * The trait for Table wire component
 */
trait TableThread
{

    /// PROPERTIES

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
    public function refreshPagination(array $pagination, callable $callback) : void
    {
        # refresh pagination
        $this->pagination = $pagination;
        # execute callback
        $callback();
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
    }

    /**
     * Open add modal to create a new resource
     * @return void
     */
    public function openAddModal() : void
    {

    }

    /**
     * Open edit modal to update a resource
     * @return void
     */
    public function openEditModal() : void
    {

    }

    /**
     * Open delete modal to remove a resource
     * @return void
     */
    public function openDeleteModal() : void
    {

    }

    /**
     * Get total of searched data
     * @param Builder $query => the query
     * @param string $childComponentPath => path of child component for emit to 'setPagination' fn
     * @param string $field => the field to count
     * @return void
     */
    public function getTotalData(Builder $query, string $childComponentPath, string $field = 'id') : void
    {
        # set 'total_records' of pagination with count of searched resources from db
        $this->pagination['total_records'] = $query->select($field)->count();
        # emit to child component to refresh pagination info
        $this->dispatch('set_pagination', $this->pagination)->to($childComponentPath);
    }

    /// STATIC FUNCTIONS

}
