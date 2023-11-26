{{-- props of component --}}
@props([
    'activity'
])

{{-- template --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-baseline w-full">

    {{-- person_id --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.activity_attendance.person') }}" for="frm.person_id" class="required"/>
        {{-- select --}}
        <x-forms.select wire:model="frm.person_id" required>
            {{-- loop generate option list of people registered in event of activity --}}
            @foreach(\App\Models\Sys\Person::query()
                        # link to event_attendances
                        ->join('event_attendances as ea', 'people.id', '=', 'ea.person_id')
                        # filter by event_id
                        ->where('ea.event_id', $activity->event_id)
                        # custom select
                        ->select('people.*')
                        # order by and get
                        ->orderBy('names')->get() as $item)
                <x-forms.option value="{{ $item->id }}" class="text-gray-700 dark:text-stone-400 font-normal">{{ $item->getFullName() }}</x-forms.option>
            @endforeach
        </x-forms.select>
        {{-- error --}}
        <x-forms.error for="frm.person_id"/>
    </x-forms.input-group>


    {{-- status --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.activity_attendance.state') }}" for="frm.state" class="required"/>
        {{-- select --}}
        <x-forms.select wire:model="frm.state" required>
            {{-- loop generate option list of participation_modalities --}}
            @foreach(\App\Models\Sys\ActivityAttendance::STATES as $item)
                <x-forms.option value="{{ $item['key'] }}" class="text-gray-700 dark:text-stone-400 font-normal">{{ __($item['key_name']) }}</x-forms.option>
            @endforeach
        </x-forms.select>
        {{-- error --}}
        <x-forms.error for="frm.state"/>
    </x-forms.input-group>


    {{-- attendance_date --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="{{ __('messages.models.activity_attendance.attendance_date') }}" for="frm.attendance_date" class="nullable"/>
        {{-- input --}}
        <x-forms.input type="datetime-local" wire:model="frm.attendance_date" required maxLength="250" placeholder="Ingresa la fecha de realización del evento"/>
        {{-- error --}}
        <x-forms.error for="frm.attendance_date"/>
    </x-forms.input-group>

</div>
