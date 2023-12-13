{{-- props of component --}}
@props([
    'event'
])

{{-- template --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-baseline w-full">

    {{-- event name --}}
    <div class="inline-flex items-center space-x-1 px-1.5 col-span-full">
        <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.event_attendance.event') }}:</span>
        <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $event->name }} ({{ $event->year }})</span>
    </div>

    {{-- person_id --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.event_attendance.person') }}" for="frm.person_id" class="required"/>
        {{-- select --}}
        <x-forms.select wire:model="frm.person_id" required>
            {{-- loop generate option list of people --}}
            @foreach(\App\Models\Sys\Person::query()->orderBy('names')->get() as $item)
                <x-forms.option value="{{ $item->id }}" class="text-gray-700 dark:text-stone-400 font-normal">{{ $item->getFullName() }}</x-forms.option>
            @endforeach
        </x-forms.select>
        {{-- error --}}
        <x-forms.error for="frm.person_id"/>
    </x-forms.input-group>

    {{-- institution_id --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.event_attendance.institution') }}" for="frm.institution_id" class="required"/>
        {{-- select --}}
        <x-forms.select wire:model="frm.institution_id" required :data="\App\Models\Sys\EventAttendance::INSTITUTIONS"/>
        {{-- error --}}
        <x-forms.error for="frm.institution_id"/>
    </x-forms.input-group>

    {{-- other_institution --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.event_attendance.other_institution') }}" for="frm.other_institution"/>
        {{-- input --}}
        <x-forms.input type="text" wire:model="frm.other_institution" required maxLength="250" placeholder="Ingresa el nombre de la Institución"/>
        {{-- error --}}
        <x-forms.error for="frm.other_institution"/>
    </x-forms.input-group>

    {{-- participation_modality --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.event_attendance.participation_modality') }}" for="frm.participation_modality" class="required"/>
        {{-- select --}}
        <x-forms.select wire:model="frm.participation_modality" required>
            {{-- loop generate option list of participation_modalities --}}
            @foreach(\App\Models\Sys\EventAttendance::PARTICIPATION_MODALITIES as $item)
                <x-forms.option value="{{ $item['key'] }}" class="text-gray-700 dark:text-stone-400 font-normal">{{ __($item['key_name']) }}</x-forms.option>
            @endforeach
        </x-forms.select>
        {{-- error --}}
        <x-forms.error for="frm.participation_modality"/>
    </x-forms.input-group>

    {{-- type --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.event_attendance.type') }}" for="frm.type" class="required"/>
        {{-- select --}}
        <x-forms.select wire:model="frm.type" required :data="\App\Models\Sys\EventAttendance::get_types()"/>
        {{-- error --}}
        <x-forms.error for="frm.type"/>
    </x-forms.input-group>

    {{-- stay_type --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.event_attendance.stay_type') }}" for="frm.stay_type" class="required"/>
        {{-- select --}}
        <x-forms.select wire:model="frm.stay_type" required :data="\App\Models\Sys\EventAttendance::get_stay_types()"/>
        {{-- error --}}
        <x-forms.error for="frm.stay_type"/>
    </x-forms.input-group>

    {{-- payment_status --}}
    @ability('*', 'event_attendances:set_as_paid')
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.event_attendance.payment_status') }}" for="frm.payment_status" class="required"/>
        {{-- select --}}
        <x-forms.select wire:model="frm.payment_status" required>
            {{-- loop generate option list of participation_modalities --}}
            @foreach(\App\Models\Sys\EventAttendance::PAYMENT_STATUSES as $item)
                <x-forms.option value="{{ $item['key'] }}" class="text-gray-700 dark:text-stone-400 font-normal">{{ __($item['key_name']) }}</x-forms.option>
            @endforeach
        </x-forms.select>
        {{-- error --}}
        <x-forms.error for="frm.payment_status"/>
    </x-forms.input-group>
    @endability

    {{-- approve_certificate_manually --}}
    @ability('*', 'event_attendances:set_approve_certificate_manually')
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.event_attendance.approve_certificate_manually') }}" for="frm.approve_certificate_manually" class="required"/>
        {{-- select --}}
        <x-forms.select wire:model="frm.approve_certificate_manually" required>
            {{-- loop generate option list of participation_modalities --}}
            @foreach(\App\Utils\CommonUtils::AFFIRMATIONS_FROM_BOOLEAN as $key => $item)
                <x-forms.option value="{{ $key }}" class="text-gray-700 dark:text-stone-400 font-normal">{{ __($item) }}</x-forms.option>
            @endforeach
        </x-forms.select>
        {{-- error --}}
        <x-forms.error for="frm.approve_certificate_manually"/>
    </x-forms.input-group>
    @endability

</div>
