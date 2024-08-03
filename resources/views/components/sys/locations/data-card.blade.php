{{-- props of component --}}
@props([
    'location',
])

{{-- php code --}}
@php
$active = $location->get_active();
@endphp

{{-- template --}}
<x-cards.card title="{{ __('messages.models.location.model_name') }}" :footer="0" color="gray-100">
    {{-- content card --}}
    <x-slot:content>

        {{-- data --}}
        <div class="flex flex-wrap items-baseline text-xs space-y-1">

            {{-- id --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">ID:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $location->id }}</span>
            </div>

            {{-- name --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.location.name') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $location->name }}</span>
            </div>

            {{-- address --}}
            <div class="inline-flex items-end space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.location.address') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $location->address }}</span>
                @if($location->is_maps_location)
                    <a
                        href="{{ $location->url }}"
                        target="_blank"
                        title="Ver ubicación en el mapa"
                    >
                        <x-utils.icon class="text-emerald-300 hover:text-emerald-500 hover:scale-110 transition ease-in-out duration-150">pin_drop</x-utils.icon>
                    </a>
                @endif
            </div>

            {{-- active --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.location.active') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-{{ $active['color'] }}-300 text-sm">{{ __($active['key_name']) }}</span>
            </div>

            {{-- created_at --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">Fecha de registro:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ \Illuminate\Support\Carbon::createFromTimeString($location->created_at)->format('Y-m-d h:i a') }}</span>
            </div>

            {{-- updated_at --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">Ultima actualización:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ \Illuminate\Support\Carbon::createFromTimeString($location->updated_at)->format('Y-m-d h:i a') }}</span>
            </div>

        </div>

    </x-slot:content>
</x-cards.card>
