{{-- props of component --}}
@props([
    'user',
    'action' => 'add',
    'event' => null,
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

    {{-- min_percent --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.event.min_percent') }}" for="frm.min_percent" class="required"/>
        {{-- input --}}
        <x-forms.input type="number" wire:model="frm.min_percent" min="1" max="100" step="1" required placeholder="Ingresa el porcentaje mínimo de asistencia de actividades para aprobar la generación del certificado"/>
        {{-- error --}}
        <x-forms.error for="frm.min_percent"/>
    </x-forms.input-group>

    <hr class="col-span-full">

    {{-- certificate_file --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.event.certificate_path') }}" for="frm.certificate_file"/>
        {{-- input --}}
        <x-forms.input type="file" accept="image/*" wire:model="frm.certificate_file" size="3062" step="1"/>
        {{-- error --}}
        <x-forms.error for="frm.certificate_file"/>
        {{-- preview of loaded file --}}
        {{--@if($this->certificate_file)
            <img src="{{ $certificate_file->temporaryUrl() }}"/>
        @endif--}}
        {{-- old file --}}
        @if($event)
            @if($event->certificate_path)
                <div class="flex flex-col space-y-1 items-start justify-start p-2 mt-2">
                    <span class="font-normal text-sm text-slate-100">Archivo guardado anteriormente:</span>
                    <img src="{{  \App\Utils\CommonUtils::getImage($event->certificate_path) }}" class="rounded-md"/>
                </div>
            @endif
        @endif
    </x-forms.input-group>

    {{-- virtual_card_file --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.event.virtual_card_path') }}" for="frm.certificate_file"/>
        {{-- input --}}
        <x-forms.input type="file" accept="image/*" wire:model="frm.virtual_card_file" size="3062" step="1"/>
        {{-- error --}}
        <x-forms.error for="frm.virtual_card_file"/>
        {{-- preview of loaded file --}}
        {{--@if($this->certificate_file)
            <img src="{{ $certificate_file->temporaryUrl() }}"/>
        @endif--}}
        {{-- old file --}}
        @if($event)
            @if($event->virtual_card_path)
                <div class="flex flex-col space-y-1 items-start justify-start p-2 mt-2">
                    <span class="font-normal text-sm text-slate-100">Archivo guardado anteriormente:</span>
                    <img src="{{  \App\Utils\CommonUtils::getImage($event->virtual_card_path) }}" class="rounded-md"/>
                </div>
            @endif
        @endif
    </x-forms.input-group>

</div>
