{{-- props of component --}}
@props([

])

{{-- php code --}}
@php
@endphp

{{-- template --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-baseline w-full">

    {{-- name --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.location.name') }}" for="frm.name" class="required"/>
        {{-- input --}}
        <x-forms.input type="text" wire:model="frm.name" required maxLength="500" placeholder="Ingresa el nombre de la ubicación"/>
        {{-- error --}}
        <x-forms.error for="frm.name"/>
    </x-forms.input-group>

    {{-- address --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.location.address') }}" for="frm.address" class="required"/>
        {{-- input --}}
        <x-forms.input type="text" wire:model="frm.address" required maxLength="500" placeholder="Ingresa la dirección de la ubicación"/>
        {{-- error --}}
        <x-forms.error for="frm.address"/>
    </x-forms.input-group>

    {{-- url --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.location.url') }}" for="frm.url"/>
        {{-- input --}}
        <x-forms.input type="text" wire:model="frm.url" required maxLength="1000" placeholder="Pega aquí la URL de la ubicación"/>
        {{-- error --}}
        <x-forms.error for="frm.url"/>
    </x-forms.input-group>

    {{-- is_maps_location --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.location.is_maps_location') }}" for="frm.is_maps_location" class="required"/>
        {{-- select --}}
        <x-forms.select wire:model="frm.is_maps_location" required :data="[1 => 'Si', 0 => 'No']"/>
        {{-- error --}}
        <x-forms.error for="frm.is_maps_location"/>
    </x-forms.input-group>

    {{-- active --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.location.active') }}" for="frm.active" class="required"/>
        {{-- select --}}
        <x-forms.select wire:model="frm.active" required :data="[1 => 'Si', 0 => 'No']"/>
        {{-- error --}}
        <x-forms.error for="frm.active"/>
    </x-forms.input-group>

</div>
