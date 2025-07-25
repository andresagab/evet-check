{{-- props of component --}}
@props([])

{{-- php code --}}
@php

    use \App\Models\Sys\Activity;
    use \App\Models\Sys\Event;

    # define dispatch references of location
    $location_dispatch_references = [
        'select' => 'select-location',
        'unselect' => 'unselect-location',
    ]

@endphp

{{-- template --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-baseline w-full">

    {{-- event_id --}}
    <x-forms.input-group class="w-full col-span-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.activity.event') }}" for="frm.event_id" class="required"/>
        {{-- select --}}
        <x-forms.select wire:model="frm.event_id" required>
            {{-- loop generate option list of people --}}
            @foreach(Event::query()->orderBy('name')->get() as $item)
                <x-forms.option value="{{ $item->id }}" class="text-gray-700 dark:text-stone-400 font-normal">{{ $item->name }}</x-forms.option>
            @endforeach
        </x-forms.select>
        {{-- error --}}
        <x-forms.error for="frm.event_id"/>
    </x-forms.input-group>

    {{-- name --}}
    <x-forms.input-group class="w-full col-span-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.activity.name') }}" for="frm.name" class="required"/>
        {{-- input --}}
        <x-forms.text-area
            wire:model="frm.name"
            placeholder="Ingresa el nombre de la actividad"
            maxLength="250"
            required
        />
        {{-- error --}}
        <x-forms.error for="frm.name"/>
    </x-forms.input-group>

    {{-- author_name --}}
    <x-forms.input-group class="w-full col-span-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.activity.author_name') }}" for="frm.author_name" class="required"/>
        {{-- input --}}
        <x-forms.text-area
            wire:model="frm.author_name"
            placeholder="Ingresa el nombre del autor o autores de la actividad"
            maxLength="250"
            required
        />
        {{-- error --}}
        <x-forms.error for="frm.author_name"/>
    </x-forms.input-group>

    {{-- slots --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.activity.slots') }}" for="frm.slots" class="required"/>
        {{-- input --}}
        <x-forms.input type="number" min="0" wire:model="frm.slots" required max="99999" placeholder="Ingresa la cantidad de cupos disponibles para esta actividad"/>
        {{-- error --}}
        <x-forms.error for="frm.slots"/>
    </x-forms.input-group>

    {{-- type --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.activity.type') }}" for="frm.type" class="required"/>
        {{-- select --}}
        <x-forms.select wire:model="frm.type" required :data="Activity::get_types()"/>
        {{-- error --}}
        <x-forms.error for="frm.type"/>
    </x-forms.input-group>

    {{-- modality --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.activity.modality') }}" for="frm.modality" class="required"/>
        {{-- select --}}
        <x-forms.select wire:model="frm.modality" required :data="\App\Models\Sys\Activity::get_modalities()"/>
        {{-- error --}}
        <x-forms.error for="frm.modality"/>
    </x-forms.input-group>

    {{-- status --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.activity.status') }}" for="frm.status" class="required"/>
        {{-- select --}}
        <x-forms.select wire:model="frm.status" required :data="\App\Models\Sys\Activity::get_status_types()"/>
        {{-- error --}}
        <x-forms.error for="frm.status"/>
    </x-forms.input-group>

    {{-- hide --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.activity.hidden') }}" for="frm.hide" class="required"/>
        {{-- select --}}
        <x-forms.select wire:model="frm.hide" required :data="[1 => 'Si', 0 => 'No']"/>
        {{-- error --}}
        <x-forms.error for="frm.hide"/>
    </x-forms.input-group>

    {{-- location --}}
    <x-forms.input-group class="w-full col-span-full">
        {{-- select --}}
        <livewire:sys.locations.searcher
            wire:key="'location-searcher'"
            label_name="{{ __('messages.models.activity.location') }}"
            :dispatch_references="$location_dispatch_references"
            :custom_list="1"
        />
        <x-forms.error for="frm.location_id"/>
    </x-forms.input-group>

    {{-- date --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.activity.date') }}" for="frm.date" class="required"/>
        {{-- input --}}
        <x-forms.input type="datetime-local" wire:model="frm.date" required maxLength="250" placeholder="Ingresa la fecha de realización del evento"/>
        {{-- error --}}
        <x-forms.error for="frm.date"/>
    </x-forms.input-group>

</div>
