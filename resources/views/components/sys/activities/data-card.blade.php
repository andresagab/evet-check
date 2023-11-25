{{-- props of component --}}
@props([
    'activity',
])

{{-- template --}}
<x-cards.card title="{{ __('messages.models.activity.model_name') }}" :footer="0" color="gray-100">
    {{-- content card --}}
    <x-slot:content>

        {{-- data --}}
        <div class="flex flex-wrap items-baseline text-xs space-y-1">

            {{-- id --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">ID:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $activity->id }}</span>
            </div>

            {{-- event name --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.activity.event') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $activity->event->name }} ({{ $activity->event->year }})</span>
            </div>

            {{-- name --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.activity.name') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $activity->name }}</span>
            </div>

            {{-- author_name --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.activity.author_name') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $activity->author_name }}</span>
            </div>

            {{-- slots --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.activity.slots') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $activity->slots }}</span>
            </div>

            {{-- free slots --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.activity.free_slots') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $activity->get_free_slots() }}</span>
            </div>

            {{-- type --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.activity.type') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $activity->get_type() }}</span>
            </div>

            {{-- modality --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.activity.modality') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $activity->get_modality() }}</span>
            </div>

            {{-- status --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.activity.status') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $activity->get_status() }}</span>
            </div>

            {{-- hidden --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.activity.hidden') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $activity->get_hidden() }}</span>
            </div>

            {{-- date --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">Fecha:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ \Illuminate\Support\Carbon::createFromTimeString($activity->date)->format('Y-m-d h:i a') }}</span>
            </div>

            {{-- created_at --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">Fecha de registro:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ \Illuminate\Support\Carbon::createFromTimeString($activity->created_at)->format('Y-m-d h:i a') }}</span>
            </div>

            {{-- updated_at --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">Ultima actualización:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ \Illuminate\Support\Carbon::createFromTimeString($activity->updated_at)->format('Y-m-d h:i a') }}</span>
            </div>

        </div>

    </x-slot:content>
</x-cards.card>
