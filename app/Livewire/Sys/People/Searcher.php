<?php

namespace App\Livewire\Sys\People;

use App\Models\Sys\Person;
use App\Utils\Threads\SearcherThread;
use Livewire\Attributes\On;
use Livewire\Component;

class Searcher extends Component
{

    /// USING
    use SearcherThread;

    /// PROPERTIES

    /**
     * The class of main model
     *
     * @var Person::class
     */
    private $class_model = Person::class;

    /// HOOKS

    /// PRIVATE FUNCTIONS

    /// PUBLIC FUNCTIONS

    /**
     * Search data resource
     *
     * @return void
     */
    public function search() : void
    {

        # always reset searched data
        $this->reset(['searched_data']);

        # if filter have data, then search
        if (strlen($this->filters['main']['text']) >= 3)
        {
            $this->searched_data = Person::query()
                # filter by name, surnames or nuip
                ->where(function ($q) {
                    # define $filter for current where
                    $filter = "%" . mb_strtolower($this->filters['main']['text'], 'UTF-8') . "%";
                    # if $this->filters['main']['text'] have data
                    if ($this->filters['main']['text'] != '')
                        # filter by names, surnames or nuip
                        return $q->whereRaw('LOWER(names) LIKE ?', [$filter])
                            ->orWhereRaw('LOWER(surnames) LIKE ?', [$filter])
                            ->orWhereRaw('LOWER(nuip) LIKE ?', [$filter]);
                    else
                        return null;
                })
                ->get();
        }
        # else, not search, then emit info message
        else
            $this->dispatch('toast', title:'Asegurate de escribir por lo menos 3 caracteres en el buscador', icon:'info');

    }

    /// EVENTS

    /**
     * Select a searched model
     * Always set it in child component
     * @param $model => the selected model
     * @param string $filter_key => key of filter to set text
     * @return void
     */
    #[On('select-model')]
    public function select_model(Person $model, $filter_key = 'main') : void
    {
        # set model
        $this->model = $model;
        # set a specified text of filter with model attribute
        $this->filters[$filter_key]['text'] = $this->model->name . " {$model->getFullName()} - ($model->nuip)";
        # dispatch to other component
        $this->dispatch($this->dispatch_references['select'], $this->model);
    }

    /**
     * Render component
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.sys.people.searcher');
    }
}
