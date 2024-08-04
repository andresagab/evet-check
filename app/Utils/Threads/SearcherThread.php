<?php

namespace App\Utils\Threads;

use App\Utils\CommonUtils;
use Livewire\Attributes\On;

trait SearcherThread
{

    /// USING

    /// PROPERTIES

    /**
     * The class of main model
     * Always set it in child component
     * @var [type]
     * private $class_model = self::class;
     */

    /**
     * The main model of searched resource
     *
     * @var mixed
     */
    public $model;

    /**
     * The searched data array list
     *
     * @var array
     */
    public $searched_data = [];

    /**
     * The filters array
     */
    public array $filters = [
        'main' => [
            'text' => '',
            'attribute' => 'name',
        ],
    ];

    /**
     * The text size of input and searched elements
     *
     * @var string
     */
    public string $text_size;

    /**
     * The label name of searcher
     *
     * @var string
     */
    public string $label_name = '';

    /**
     * Default value for custom list is false, set it as true to enable slot for custom list in view
     *
     * @var boolean
     */
    public bool $custom_list = false;

    /**
     * The dispatch references for select and unselect actions, set it as listener of parent component that select or unselect the searched model
     *
     * @var array|string[]
     */
    public array $dispatch_references = [
        'select' => 'select-parent-model',
        'unselect' => 'unselect-parent-model',
    ];

    /// HOOKS

    /**
     * When component is mounted
     *
     * @param string $text_size the text size of input
     * @param string $label_name the label name of searcher
     * @param array|null $filters the filters array, array with text and attribute keys
     * @param array|null $dispatch_references the dispatch references to select or unselect searched model in parent component
     * @param bool $custom_list
     * @return void
     */
    public function mount(string $text_size = 'sm', string $label_name = 'The label name', array $filters = null, array $dispatch_references = null, bool $custom_list = false) : void
    {
        # set init values
        $this->model = new $this->class_model();
        $this->text_size = CommonUtils::TEXT_SIZE[$textSize ?? 'sm'];
        $this->label_name = $label_name;
        $this->custom_list = $custom_list;
        # if filters arguments is not null
        if ($filters !== null)
            $this->filters = $filters;
        # if dispatch references arguments is not null
        if ($dispatch_references !== null)
            $this->dispatch_references = $dispatch_references;
    }

    /// PRIVATE FUNCTIONS

    /**
     * Reset the text of filters
     *
     * @return void
     */
    private function reset_text_filters() : void
    {
        foreach ($this->filters as $key => $filter)
            $this->filters[$key]['text'] = '';
    }

    /// PUBLIC FUNCTIONS

    /**
     * Search data resource
     * Always set it in parent component, for search use the 'text' key of each filter
     *
     * @return void
     *
     * public function search() : void
     * {
     *
     * }
     *
     */

    /// EVENTS

    /**
     * Select a searched model
     * Always set it in child component to use functions or custom keys form model object
     * @param $model
     * @param string $filter_key
     * @return void
     */
    #[On('select-model')]
    public function select_model($model, $filter_key = 'main') : void
    {
        # set model (this is identified as array, not object)
        $this->model = $model;
        # set a specified text of filter with model attribute
        $this->filters[$filter_key]['text'] = $model[$this->filters[$filter_key]['attribute']];
        # dispatch to other component
        $this->dispatch($this->dispatch_references['select'], $this->model);
    }

    /**
     * Unselect searched model
     * @return void
     */
    #[On('unselect-model')]
    public function unselect_model() : void
    {
        # reset model as new object
        $this->model = new $this->class_model();
        # reset filters
        $this->reset_text_filters();
        $this->reset(['searched_data']);
        # dispatch to other component
        $this->dispatch($this->dispatch_references['unselect'], $this->model);
    }

}
