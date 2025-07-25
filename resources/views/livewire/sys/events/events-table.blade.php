<div wire:init="search(true, true)">

    {{-- full-page-loader --}}
    <x-loaders.full-page-loader wire:loading wire:target='search, openAddModal, openEditModal, openDeleteModal'/>

    {{-- sub header --}}
    <x-layouts.headers.sub-header title="{{ __('messages.menu.events') }}" :actions="true">

        {{-- add button --}}
        @ability('*', 'events:add')
        <x-buttons.circle-icon-button wire:click="openAddModal" wire.offline="disabled" wire:loading.class="hidden" color="green">add</x-buttons.circle-icon-button>
        @endability

    </x-layouts.headers.sub-header>

    {{-- content page --}}
    <x-layouts.pages.content.base-content-page-layout>

        {{-- filters section --}}
        <x-cards.card title="Búsqueda">

            {{-- content --}}
            <x-slot:content>
                {{-- filters layer --}}
                <div class="flex flex-col w-full space-y-3">
                    {{-- inputs --}}
                    <div class="flex flex-row items-center space-x-2 w-full">

                        {{-- filters.name --}}
                        <div class="flex flex-col items-start w-full">
                            <label class="font-semibold text-sm text-zinc-900 dark:text-stone-100" for="filters.name">{{ __('messages.models.event.name') }}:</label>
                            <input wire:model="filters.name" wire:keydown.enter='search(true, true)' type="text" name="filters.name" id="filters.name" placeholder="{{ __('messages.models.event.filters.name') }}" class="border-none px-2 py-1 text-sm w-full bg-white-200 dark:bg-slate-900 dark:text-stone-200 rounded-md">
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
                        <span class="font-semibold text-xs text-zinc-700 dark:text-stone-300">{{ count($events) }}</span>
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
                    <th class="px-2 py-1 text-left w-96">{{ __('messages.models.event.name') }}</th>
                    <th class="px-2 py-1 text-left w-32">{{ __('messages.models.event.year') }}</th>
                    <th class="px-2 py-1 text-center w-44">{{ __('messages.models.event.registered_people') }}</th>
                    <th class="px-2 py-1 text-left w-32">{{ __('messages.models.event.state') }}</th>
                    <th class="px-2 py-1 text-left w-32">{{ __('messages.models.event.symbolic_cost') }}</th>
                    <th class="px-2 py-1 text-left w-60">{{ __('messages.data.dates') }}</th>
                    <th class="px-2 py-1 w-60"></th>
                </tr>
                </thead>
                {{-- body --}}
                <tbody>
                @foreach ($events as $item)

                    {{-- php code --}}
                    @php
                        # load state reference
                        $state = $item->get_state();
                    @endphp

                    <tr class="border-b border-b-blue-300 dark:border-b-slate-500 bg-white dark:bg-slate-600 hover:bg-blue-100 dark:hover:bg-slate-500 dark:text-stone-50 dark:hover:text-white hover:shadow transition ease-in-out duration-300">

                        {{-- id event --}}
                        <td class="p-2 text-center">{{ $item->id }}</td>
                        {{-- name --}}
                        <td class="p-2 text-left">
                            <span class="font-bold text-sm">{{ $item->name }}</span>
                        </td>
                        {{-- year --}}
                        <td class="p-2 text-left">
                            <span class="font-semibold text-sm">{{ $item->year }}</span>
                        </td>
                        {{-- registered people --}}
                        <td class="p-2 text-center">
                            <span class="font-bold text-sm">{{ $item->event_attendances()->count() }}</span>
                        </td>
                        {{-- state --}}
                        <td class="p-2 text-left">
                            <span class="font-bold text-sm text-{{ $state['color'] }}-700 dark:text-{{ $state['color'] }}-300">{{ __($state['key_name']) }}</span>
                        </td>
                        {{-- symbolic_cost --}}
                        <td class="p-2 text-left">
                            <span class="font-normal text-sm">${{ number_format($item->symbolic_cost) }}</span>
                        </td>
                        {{-- dates --}}
                        <td class="p-2 text-left">
                            <x-tables.dates-columns :created_at="$item->created_at" :updated_at="$item->updated_at"/>
                        </td>
                        {{-- actions --}}
                        <td>
                            <div class="inline-flex items-center space-x-1">
                                {{-- edit --}}
                                @ability('*', 'events:edit')
                                <x-buttons.circle-icon-button wire:click="openEditModal({{ $item }})" title="Click para editar este registro" color="violet" size="20px">edit</x-buttons.circle-icon-button>
                                @endability
                                {{-- delete --}}
                                @if($item->can_delete() && Laratrust::ability('*', 'events:delete'))
                                <x-buttons.circle-icon-button wire:click="openDeleteModal({{ $item }})" title="Click para eliminar este registro" color="red" size="20px">delete</x-buttons.circle-icon-button>
                                @endif
                                {{-- report attendees --}}
                                @ability('*', 'events:reports:attendees-participation')
                                    <a href="{{ route('sys.reports.events.attendees', $item) }}"><x-buttons.circle-icon-button title="Click para ver el reporte de asistencia y participación de este evento" color="sky" size="20px">file_present</x-buttons.circle-icon-button></a>
                                @endability
                                {{-- event attendances --}}
                                @ability('*', 'event_attendances')
                                <a href="{{ route('sys.events.attendances', $item) }}"><x-buttons.circle-icon-button title="Click para gestionar la asistencia del evento" color="blue" size="20px">diversity_3</x-buttons.circle-icon-button></a>
                                @endability
                                {{-- manage-event-permissions --}}
                                @ability('*', 'events:manage-activities')
                                    {{--<x-buttons.circle-icon-button wire:click="open_manage_role_permissions({{ $item->user }})" title="Click para gestionar los permisos de este registro" color="emerald" size="20px">manage_accounts</x-buttons.circle-icon-button>--}}
                                @endability
                                {{-- setup-certificate --}}
                                @ability('*', 'events:setup-certificate')
                                    <x-buttons.circle-icon-button wire:click="open_certificate_form_modal({{ $item }})" title="Click para configurar el certificado del evento" color="amber" size="20px">workspace_premium</x-buttons.circle-icon-button>
                                @endability
                                {{-- setup-certificate --}}
                                @ability('*', 'events:setup-virtual-card')
                                    <x-buttons.circle-icon-button wire:click="open_virtual_card_form_modal({{ $item }})" title="Click para configurar el carnet virtual del evento" color="teal" size="20px">badge</x-buttons.circle-icon-button>
                                @endability
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

    {{-- event-form --}}
    <livewire:sys.events.event-form/>
    {{-- event-delete --}}
    <livewire:sys.events.event-delete/>
    {{-- certificate-setup-form --}}
    <livewire:sys.events.certificate-setup-form/>
    {{-- virtual-card-setup-form --}}
    <livewire:sys.events.virtual-card-setup-form/>

</div>
