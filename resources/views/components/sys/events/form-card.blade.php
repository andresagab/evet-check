{{-- props of component --}}
@props([
    'user',
    'action' => 'add',
    'profile_photo' => null,
])

{{-- template --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-baseline w-full">

    {{-- name --}}
    <x-forms.input-group class="w-full col-span-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.event.name') }}" for="frm.name" class="required"/>
        {{-- input --}}
        <x-forms.text-area wire:model="frm.name" required maxLength="250" rows="3" placeholder="Ingresa el nombre del evento"/>
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

    {{-- state --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.event.state') }}" for="frm.state" class="required"/>
        {{-- select --}}
        <x-forms.select wire:model="frm.state" required>
            {{-- loop generate option list of participation_modalities --}}
            @foreach(\App\Models\Sys\Event::STATES as $item)
                <x-forms.option value="{{ $item['key'] }}" class="text-gray-700 dark:text-stone-400 font-normal">{{ __($item['key_name']) }}</x-forms.option>
            @endforeach
        </x-forms.select>
        {{-- error --}}
        <x-forms.error for="frm.state"/>
    </x-forms.input-group>

    {{-- symbolic_cost --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.event.symbolic_cost') }}" for="frm.symbolic_cost" class="required"/>
        {{-- input --}}
        <x-forms.input type="number" wire:model="frm.symbolic_cost" min="0" step="1" required placeholder="Ingresa el valor del pago simbólico"/>
        {{-- error --}}
        <x-forms.error for="frm.symbolic_cost"/>
    </x-forms.input-group>

</div>
