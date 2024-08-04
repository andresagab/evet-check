{{-- props of component --}}
@props([
    'label_name',
    'filter_wire_model' => 'filters.main.text',
    'filter_placeholder' => '',
    'text_size',
    'filters',
    'model',
    'searched_data',
    'displayable_attribute_item' => 'name',
    'displayable_function_item' => null,
    'custom_list' => false,
])

{{-- php code --}}
@php

    @endphp

{{-- template --}}
<div class="w-full">

    {{-- loader --}}
    <x-loaders.section-loader wire:loading/>

    <div class="flex flex-col w-full">
        {{-- input searcher --}}
        <div class="flex flex-col items-start w-full">
            {{-- label --}}
            <x-forms.label for="filters.name" class="required">{{ $label_name }}:</x-forms.label>
            {{-- input and buttons --}}
            <div class="flex flex-row items-center space-x-2 w-full">
                {{-- searcher --}}
                <input wire:model="{{ $filter_wire_model }}" wire:keyup.enter="search" wire:keyup.control="search" placeholder="{{ $filter_placeholder }}" @if($model->id) readonly @endif class="flex-grow px-2 py-1 {{ $text_size }} w-full bg-white-200 dark:bg-gray-900 rounded-md focus:outline-none focus:border focus:border-indigo-700 font-normal text-gray-900 dark:text-stone-100 appearance-none transition ease-in-out duration-300">
                {{-- if model is selected --}}
                @if(!$model->id)
                    {{-- search button --}}
                    <x-buttons.circle-icon-button type="button" color="blue" wire:click="search">search</x-buttons.circle-icon-button>
                    {{-- else, a model is not selected --}}
                @else
                    {{-- unselect button --}}
                    <x-buttons.circle-icon-button type="button" color="red" wire:click="unselect_model">remove</x-buttons.circle-icon-button>
                @endif
            </div>
        </div>
        <div class="relative w-full">
            {{-- if filter have data and a searched_data count is zero --}}
            @if(strlen($filters['main']['text']) > 0 && count($searched_data) === 0 && !$model->id)
                <span class="font-semibold text-sm text-blue-700 dark:text-blue-300 italic">No se encontraron resultados</span>
                {{-- else, if data was fund and model is not selected --}}
            @elseif(count($searched_data) > 0 && !$model->id && !$custom_list)

                {{-- searched data --}}
                <ul class="relative w-full max-h-40 overflow-y-auto overflow-x-auto rounded-md bg-white dark:bg-slate-900 border-gray-300 dark:border-slate-600 divide-y" tabindex="-1">
                    @foreach($searched_data as $item)
                        <li class="cursor-pointer py-1 px-2 hover:bg-gray-300 dark:hover:bg-slate-700 focus:bg-gray-300 dark:focus:bg-slate-700 font-semibold dark:text-white {{ $text_size }}" wire:keyup.enter="select_model({{ $item }})" wire:click="select_model({{ $item }})" tabindex="-1">{{ $displayable_function_item ? $item->{$displayable_function_item}() : $item->{$displayable_attribute_item} }}</li>
                    @endforeach
                </ul>
            @elseif(count($searched_data) > 0 && !$model->id && $custom_list)
                <ul class="relative w-full max-h-40 overflow-y-auto overflow-x-auto rounded-md bg-white dark:bg-slate-900 border-gray-300 dark:border-slate-600 divide-y" tabindex="-1">
                    {{ $slot }}
                </ul>
            @endif
        </div>
    </div>

</div>
