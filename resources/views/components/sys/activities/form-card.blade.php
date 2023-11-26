{{-- props of component --}}
@props([])

{{-- template --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-baseline w-full">

    {{-- event_id --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.activity.event') }}" for="frm.event_id" class="required"/>
        {{-- select --}}
        <x-forms.select wire:model="frm.event_id" required>
            {{-- loop generate option list of people --}}
            @foreach(\App\Models\Sys\Event::query()->orderBy('name')->get() as $item)
                <x-forms.option value="{{ $item->id }}" class="text-gray-700 dark:text-stone-400 font-normal">{{ $item->name }}</x-forms.option>
            @endforeach
        </x-forms.select>
        {{-- error --}}
        <x-forms.error for="frm.event_id"/>
    </x-forms.input-group>

    {{-- name --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.activity.name') }}" for="frm.name" class="required"/>
        {{-- input --}}
        <x-forms.input type="text" wire:model="frm.name" required maxLength="250" placeholder="Ingresa el nombre de la actividad"/>
        {{-- error --}}
        <x-forms.error for="frm.name"/>
    </x-forms.input-group>

    {{-- author_name --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.activity.author_name') }}" for="frm.author_name" class="required"/>
        {{-- input --}}
        <x-forms.input type="text" wire:model="frm.author_name" required maxLength="250" placeholder="Ingresa el nombre del autor"/>
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
        <x-forms.select wire:model="frm.type" required :data="\App\Models\Sys\Activity::get_types()"/>
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
