{{-- props of component --}}
@props([
    'user',
    'action' => 'add',
    'profile_photo' => null,
])

{{-- template --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-baseline w-full">

    {{-- names --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.person.names') }}" for="frm.names" class="required"/>
        {{-- input --}}
        <x-forms.input type="text" wire:model="frm.names" required maxLength="250" placeholder="Ingresa los nombres de la persona"/>
        {{-- error --}}
        <x-forms.error for="frm.names"/>
    </x-forms.input-group>
    {{-- surnames --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.person.surnames') }}" for="frm.surnames" class="required"/>
        {{-- input --}}
        <x-forms.input type="text" wire:model="frm.surnames" required maxLength="250" placeholder="Ingresa los apellidos de la persona"/>
        {{-- error --}}
        <x-forms.error for="frm.surnames"/>
    </x-forms.input-group>
    {{-- nuip --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.person.nip') }}" for="frm.nuip" class="required"/>
        {{-- input --}}
        <x-forms.input type="text" wire:model="frm.nuip" required maxLength="250" placeholder="Ingresa el número de identificación de la persona"/>
        {{-- error --}}
        <x-forms.error for="frm.nuip"/>
    </x-forms.input-group>
    {{-- sex --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.person.sex') }}" for="frm.sex" class="required"/>
        {{-- select --}}
        <x-forms.select wire:model="frm.sex" required :data="\App\Models\Sys\Person::SEX_TYPES"/>
        {{-- error --}}
        <x-forms.error for="frm.sex"/>
    </x-forms.input-group>
    {{-- cel --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.person.cel') }}" for="frm.cel"/>
        {{-- input --}}
        <x-forms.input type="text" wire:model="frm.cel"  maxLength="15" placeholder="Ingresa el número de celular"/>
        {{-- error --}}
        <x-forms.error for="frm.cel"/>
    </x-forms.input-group>
    {{-- phone --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.person.phone') }}" for="frm.phone"/>
        {{-- input --}}
        <x-forms.input type="text" wire:model="frm.phone"  maxLength="15" placeholder="Ingresa el número de teléfono"/>
        {{-- error --}}
        <x-forms.error for="frm.phone"/>
    </x-forms.input-group>
    {{-- email --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.person.email') }}" for="frm.email"/>
        {{-- input --}}
        <x-forms.input type="email" wire:model="frm.email"  maxLength="250" placeholder="Ingresa la dirección de correo electrónico"/>
        {{-- error --}}
        <x-forms.error for="frm.email"/>
    </x-forms.input-group>

</div>
