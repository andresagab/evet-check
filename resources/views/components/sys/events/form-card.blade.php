{{-- props of component --}}
@props([
    'user',
    'action' => 'add',
    'profile_photo' => null,
])

{{-- template --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-baseline w-full">

    {{-- name --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.event.name') }}" for="frm.name" class="required"/>
        {{-- input --}}
        <x-forms.input type="text" wire:model="frm.name" required maxLength="250" placeholder="Ingresa el nombre del evento"/>
        {{-- error --}}
        <x-forms.error for="frm.name"/>
    </x-forms.input-group>

    {{-- year --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.event.year') }}" for="frm.year" class="required"/>
        {{-- input --}}
        <x-forms.input type="number" wire:model="frm.year" step="1" required maxLength="250" placeholder="Ingresa el año en el que se realiza el evento"/>
        {{-- error --}}
        <x-forms.error for="frm.year"/>
    </x-forms.input-group>

</div>
