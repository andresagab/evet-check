<?php

namespace App\Livewire\Utilities;

use App\Utils\CommonUtils;
use Livewire\Attributes\On;
use Livewire\Component;

class DataPaginator extends Component
{

    /// properties

    /**
     * Array of pagination info
     * @var array|int[]
     */
    public array $pagination = [
        'page' => 1,
        'per_page' => 10,
        'total_pages' => 0,
        'total_records' => 0,
    ];

    /**
     * The emit up reference to call when pagination is done
     * @var string
     */
    public string $emitUpRef = 'refreshPagination';

    /**
     * The listeners of component
     * @var string[]
     */
    protected $listeners = ['managePage', 'setTotalRecords', 'setPagination'];

    /// hooks

    /**
     * When component is mounted
     * @param string $emitUpReference => the emit up reference to call after do a pagination action
     * @return void
     */
    public function mount(string $emitUpReference = 'refreshPagination') : void
    {
        # set properties with initial or default vale
        $this->emitUpRef = $emitUpReference;
    }

    /// private functions

    /// public functions

    /**
     * set pagination array data
     * @param array $pagination
     * @return void
     */
    #[On('set_pagination')]
    public function setPagination(array $pagination) : void
    {
        # set pagination data
        $this->pagination = $pagination;
        # call to set total pages
        $this->setTotalPages();
    }

    /**
     * set number of total records
     * @param int $totalRecords
     * @return void
     */
    public function setTotalRecords(int $totalRecords = 0) : void
    {
        $this->pagination['total_records'] = $totalRecords;
        # call to set total pages
        $this->setTotalPages();
    }

    /**
     * set number of total pages with calc
     * @return void
     */
    public function setTotalPages() : void
    {
        # calc total pages
        $this->pagination['total_pages'] = ceil($this->pagination['total_records'] / $this->pagination['per_page']);
    }

    /**
     * manage pagination updating current page
     * @param int $setPage => default 0 to stay in current page, -1 to forward a one page or 1 for go to next page
     * @param bool $gotTo => go to this page
     * @return void
     */
    public function managePage(int $setPage = 0, bool $gotTo = false) : void
    {
        # if current page is not a number
        if (!CommonUtils::isNumber($this->pagination['page']))
        {
            # emit error message
            $this->dispatch('toast', "El valor de página ingresado no es válido", 'error');
            # set page at 1
            $this->pagination['page'] = 1;
        }
        # if current page is lower than total pages, then set current page
        if ($this->pagination['page'] > 0 && $this->pagination['page'] <= $this->pagination['total_pages'])
            $this->pagination['page'] += $setPage;
        # if current page is greater than total pages
        elseif ($gotTo && $this->pagination['page'] > $this->pagination['total_pages'])
        {
            # emit error toast message
            $this->dispatch('toast', title: "No es posible ir a la página {$this->pagination['page']} porque supera el limite de " . round($this->pagination['total_pages']), icon: 'warning');
            # set page at 1
            $this->pagination['page'] = 1;
        }
        # emit to reload data in main component
        $this->dispatch($this->emitUpRef, $this->pagination);
    }

    /// events

    /**
     * Render view of component
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.utilities.data-paginator');
    }
}
