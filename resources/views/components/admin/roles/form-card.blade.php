{{-- props of component --}}
@props([])

{{-- template --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-baseline w-full">
    {{-- role.name --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.role.name') }}:" for="frm.name" class="required"/>
        {{-- input --}}
        <x-forms.input type="text" wire:model="frm.name" required maxLength="100" placeholder="Nombre clave del role"/>
        {{-- error --}}
        <x-forms.error for="frm.name"/>
    </x-forms.input-group>
    {{-- frm.display_name --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.role.display_name') }}:" for="frm.display_name" class="required"/>
        {{-- input --}}
        <x-forms.input type="text" wire:model="frm.display_name" required maxLength="100" placeholder="Nombre a mostrar en pantalla"/>
        {{-- error --}}
        <x-forms.error for="frm.display_name"/>
    </x-forms.input-group>
    {{-- frm.description --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.role.description') }}:" for="frm.description" class="required"/>
        {{-- input --}}
        <x-forms.text-area wire:model="frm.description" required maxLength="250" placeholder="Descripción del role"/>
        {{-- error --}}
        <x-forms.error for="frm.description"/>
    </x-forms.input-group>
</div>
