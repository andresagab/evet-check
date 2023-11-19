{{-- props of component --}}
@props([
    'event',
])

{{-- template --}}
<x-cards.card title="{{ __('messages.models.event.model_name') }}" :footer="0" color="gray-100">
    {{-- content card --}}
    <x-slot:content>

        {{-- data --}}
        <div class="flex flex-wrap items-baseline text-xs space-y-1">

            {{-- id --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">ID:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $event->id }}</span>
            </div>

            {{-- name --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.event.name') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $event->name }}</span>
            </div>

            {{-- year --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.event.year') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $event->year }}</span>
            </div>

            {{-- created_at --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">Fecha de registro:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ \Illuminate\Support\Carbon::createFromTimeString($event->created_at)->format('Y-m-d h:i a') }}</span>
            </div>

            {{-- updated_at --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">Ultima actualización:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ \Illuminate\Support\Carbon::createFromTimeString($event->updated_at)->format('Y-m-d h:i a') }}</span>
            </div>

        </div>

    </x-slot:content>
</x-cards.card>
