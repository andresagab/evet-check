{{-- props of component --}}
@props([
    'role'
])

{{-- template --}}
<x-cards.card title="Rol" :footer="0" color="gray-100">

    {{-- content card --}}
    <x-slot:content>

        {{-- data --}}
        <div class="flex flex-wrap items-baseline text-xs space-y-1">

            {{-- id --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">ID:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $role->id ?? __('messages.data.unknown') }}</span>
            </div>
            {{-- name --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.role.name') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $role->name ?? __('messages.data.unknown') }}</span>
            </div>
            {{-- display_name --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.role.display_name') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $role->display_name ?? __('messages.data.unknown') }}</span>
            </div>
            {{-- description --}}
            <div class="inline-flex items-center space-x-1 px-1.5">
                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.role.description') }}:</span>
                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $role->description ?? __('messages.data.unknown') }}</span>
            </div>

        </div>

    </x-slot:content>

</x-cards.card>
