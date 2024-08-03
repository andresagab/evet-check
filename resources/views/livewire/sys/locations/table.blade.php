<div wire:init="search(true, true)">

    {{-- full-page-loader --}}
    <x-loaders.full-page-loader wire:loading/>

    {{-- sub header --}}
    <x-layouts.headers.sub-header title="{{ __('messages.menu.locations') }}" :actions="true">

        {{-- add button --}}
        @ability('*', 'locations:add')
        <x-buttons.circle-icon-button wire:click="openAddModal" wire.offline="disabled" wire:loading.class="hidden" color="green">add</x-buttons.circle-icon-button>
        @endability

    </x-layouts.headers.sub-header>

    {{-- content page --}}
    <x-layouts.pages.content.base-content-page-layout padding="p-8">

        {{-- filters section --}}
        <x-cards.card title="{{ __('messages.content_page.searcher') }}">

            {{-- content --}}
            <x-slot:content>
                {{-- filters layer --}}
                <div class="flex flex-col w-full space-y-3">
                    {{-- inputs --}}
                    <div class="flex flex-row items-center space-x-2 w-full">

                        {{-- filters.name --}}
                        <div class="flex flex-col items-start w-full">
                            <label class="font-semibold text-sm text-zinc-900 dark:text-stone-100" for="filters.name">{{ __('messages.models.location.name') }}:</label>
                            <input wire:model="filters.name" wire:keydown.enter='search(true, true)' type="text" name="filters.name" id="filters.name" placeholder="{{ __('messages.models.location.filters.name') }}" class="border-none px-2 py-1 text-sm w-full bg-white-200 dark:bg-slate-900 dark:text-stone-200 rounded-md">
                        </div>

                    </div>
                </div>
            </x-slot:content>

            {{-- main_footer --}}
            <x-slot:main_footer>
                {{-- pagination.per_page --}}
                <div class="flex flex-row items-center space-x-3 w-full">
                    {{-- total_records --}}
                    <div class="flex flex-row items-center space-x-1 select-none">
                        <span class="font-semibold text-xs text-zinc-900 dark:text-stone-100">Registros cargados:</span>
                        <span class="font-semibold text-xs text-zinc-700 dark:text-stone-300">{{ count($locations) }}</span>
                    </div>
                    {{-- per_page --}}
                    <div class="flex flex-row items-center space-x-1 select-none">
                        <label class="font-semibold text-xs text-zinc-900 dark:text-stone-100" for="pagination.per_page">Registros por página:</label>
                        <select wire:model="pagination.per_page" name="pagination.per_page" id="pagination.per_page" class="border-none bg-white dark:bg-slate-900 dark:text-stone-300 text-xs font-zinc-700 rounded-md p-0.5 w-16">
                            @foreach (\App\Utils\CommonUtils::RECORDS_PER_PAGE as $item)
                                <option class="bg-zinc-100 dark:bg-slate-900 text-zinc-700 dark:text-stone-300" value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </x-slot:main_footer>
            {{-- secondary_footer --}}
            <x-slot:secondary_footer>
                {{-- actions --}}
                <div class="inline-flex items-center justify-end w-full">
                    {{-- search button --}}
                    <x-buttons.circle-icon-button wire:click="search(true, true)" type="button" color="blue" title="Click para buscar">search</x-buttons.circle-icon-button>
                </div>
            </x-slot:secondary_footer>

        </x-cards.card>

        {{-- data table --}}
        <x-tables.base-table-layout color="emerald" class="overflow-x-auto">
            <table class="table table-fixed border border-emerald-300 dark:border-slate-700 w-full">
                {{-- thead --}}
                <thead>
                <tr class="bg-emerald-300 dark:bg-slate-700 text-emerald-900 dark:text-slate-100 text-sm font-bold uppercase">
                    <th class="px-2 py-1 text-left w-10">ID</th>
                    <th class="px-2 py-1 text-left w-96">{{ __('messages.models.location.model_name') }}</th>
                    <th class="px-2 py-1 text-left w-96">{{ __('messages.models.location.address') }}</th>
                    <th class="px-2 py-1 text-center w-60">{{ __('messages.models.location.active') }}</th>
                    <th class="px-2 py-1 text-left w-60">{{ __('messages.data.dates') }}</th>
                    <th class="px-2 py-1 w-min max-w-min"></th>
                </tr>
                </thead>
                {{-- body --}}
                <tbody>
                @foreach ($locations as $item)

                    {{-- php code --}}
                    @php
                    $active = $item->get_active();
                    @endphp

                    <tr class="border-b border-b-blue-300 dark:border-b-slate-500 bg-white dark:bg-slate-600 hover:bg-blue-100 dark:hover:bg-slate-500 dark:text-stone-50 dark:hover:text-white hover:shadow transition ease-in-out duration-300">

                        {{-- id event --}}
                        <td class="p-2 text-center">{{ $item->id }}</td>
                        {{-- location --}}
                        <td class="p-2 text-left">
                            {{-- name --}}
                            <span class="font-bold text-sm">{{ $item->name }}</span>
                        </td>
                        {{-- address --}}
                        <td class="p-2 text-left truncate">
                            <div class="flex flex-col">
                                @if($item->address)
                                    <span class="font-medium text-sm">{{ $item->address }}</span>
                                    @if($item->is_maps_location)
                                        <a
                                            href="{{ $item->url }}"
                                            target="_blank"
                                            title="Ver ubicación en el mapa"
                                            class="text-zinc-300 text-sm italic hover:underline transition ease-in-out duration-150"
                                        >
                                            Ver
                                        </a>
                                    @endif
                                @else
                                    <x-utils.colored-text color="red">{{ __('messages.data.unregistered') }}</x-utils.colored-text>
                                @endif
                            </div>
                        </td>
                        {{-- active --}}
                        <td class="p-2 text-center">
                            <x-utils.cheap :color="$active['color']" class="text-sm font-medium">{{ __($active['key_name']) }}</x-utils.cheap>
                        </td>
                        {{-- dates --}}
                        <td class="p-2 text-left">
                            <x-tables.dates-columns :created_at="$item->created_at" :updated_at="$item->updated_at"/>
                        </td>
                        {{-- actions --}}
                        <td class="p-2 w-min">
                            <div class="flex items-center space-x-1">
                                {{-- edit --}}
                                @ability('*', 'locations:edit')
                                <x-buttons.circle-icon-button wire:click="openEditModal({{ $item }})" title="Click para editar este registro" color="violet" size="20px">edit</x-buttons.circle-icon-button>
                                @endability
                                {{-- delete --}}
                                @if($item->can_delete() && Laratrust::ability('*', 'locations:delete'))
                                    <x-buttons.circle-icon-button wire:click="openDeleteModal({{ $item }})" title="Click para eliminar este registro" color="red" size="20px">delete</x-buttons.circle-icon-button>
                                @endif
                            </div>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </x-tables.base-table-layout>

        {{-- data-paginator --}}
        <livewire:utilities.data-paginator/>

    </x-layouts.pages.content.base-content-page-layout>

    {{-- include wire components --}}

    {{-- location-form --}}
    <livewire:sys.locations.form/>
    {{-- location-delete --}}
    <livewire:sys.locations.delete/>

</div>
