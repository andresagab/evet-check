{{-- props of component --}}
@props([

])

{{-- php code --}}
@php
@endphp

{{-- template --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-baseline w-full">

    {{-- name --}}
    <x-forms.input-group class="w-full col-span-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.location.name') }}" for="frm.name" class="required"/>
        {{-- input --}}
        <x-forms.text-area
            wire:model="frm.name"
            placeholder="Ingresa el nombre de la ubicación"
            maxLength="500"
        />
        {{-- error --}}
        <x-forms.error for="frm.name"/>
    </x-forms.input-group>

    {{-- address --}}
    <x-forms.input-group class="w-full col-span-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.location.address') }}" for="frm.address" />
        {{-- input --}}
        <x-forms.text-area
            wire:model="frm.address"
            placeholder="Ingresa la dirección de la ubicación"
            maxLength="500"
        />
        {{-- error --}}
        <x-forms.error for="frm.address"/>
    </x-forms.input-group>

    {{-- url --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.location.url') }}" for="frm.url"/>
        <div class="flex items-center gap-2 w-full">
            {{-- input --}}
            <x-forms.input
                type="text"
                wire:model="frm.url"
                required maxLength="1000"
                placeholder="Pega aquí la URL de la ubicación"
                class="grow"
            />
            {{-- maps icon anchor --}}
            <a
                href="https://www.google.com/maps"
                target="_blank"
                title="Abrir Google Maps"
            >
                <x-utils.icon class="text-sky-500 hover:text-sky-300 hover:scale-110 transition ease-in-out duration-300">public</x-utils.icon>
            </a>
        </div>
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
