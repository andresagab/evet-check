{{-- props of component --}}
@props([
    'attendance',
])

{{-- template --}}
<x-cards.card title="{{ __('messages.models.event_attendance.model_name') }}" :footer="0" color="gray-100">
    {{-- content card --}}
    <x-slot:content>

        {{-- data --}}
        <div class="flex flex-wrap items-baseline text-xs space-y-1">

            {{-- id --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">ID:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $attendance->id }}</span>
            </div>

            {{-- event name --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.event_attendance.event') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $attendance->event->name }} ({{ $attendance->event->year }})</span>
            </div>

            {{-- person --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.event_attendance.person') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $attendance->person->getFullName() }}</span>
            </div>

            {{-- institution --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.event_attendance.institution') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $attendance->get_institution() }}</span>
            </div>

            {{-- participation_modality --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.event_attendance.participation_modality') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ __($attendance->get_participation_modality('key_name')) }}</span>
            </div>

            {{-- type --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.event_attendance.type') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $attendance->get_type() }}</span>
            </div>

            {{-- stay_type --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.event_attendance.stay_type') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $attendance->get_stay_type() }}</span>
            </div>

            {{-- created_at --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">Fecha de registro:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ \Illuminate\Support\Carbon::createFromTimeString($attendance->created_at)->format('Y-m-d h:i a') }}</span>
            </div>

            {{-- updated_at --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">Ultima actualización:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ \Illuminate\Support\Carbon::createFromTimeString($attendance->updated_at)->format('Y-m-d h:i a') }}</span>
            </div>

        </div>

    </x-slot:content>
</x-cards.card>
