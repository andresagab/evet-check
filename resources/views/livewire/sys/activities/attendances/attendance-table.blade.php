<div wire:init="search(true, true)">

    {{-- full-page-loader --}}
    <x-loaders.full-page-loader wire:loading wire:target='search, openAddModal, openEditModal, openDeleteModal'/>

    {{-- sub header --}}
    <x-layouts.headers.sub-header title="{{ __('messages.menu.activity_attendances') }} | {{ $activity->name }}" :actions="true">

        {{-- add button --}}
        @ability('*', 'activity_attendances:add')
        <x-buttons.circle-icon-button wire:click="openAddModal" wire.offline="disabled" wire:loading.class="hidden" color="green">add</x-buttons.circle-icon-button>
        @endability

        {{-- back --}}
        <a href="javascript:history.back()"> <x-buttons.circle-icon-button title="{{ __('messages.data.action.go_back') }}" color="yellow" size="20px">undo</x-buttons.circle-icon-button></a>

    </x-layouts.headers.sub-header>

    {{-- content page --}}
    <x-layouts.pages.content.base-content-page-layout>

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
                            <label class="font-semibold text-sm text-zinc-900 dark:text-stone-100" for="filters.name">{{ __('messages.models.event_attendance.event') }}:</label>
                            <input wire:model="filters.name" wire:keydown.enter='search(true, true)' type="text" name="filters.name" id="filters.name" placeholder="{{ __('messages.models.event_attendance.filters.name') }}" class="border-none px-2 py-1 text-sm w-full bg-white-200 dark:bg-slate-900 dark:text-stone-200 rounded-md">
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
                        <span class="font-semibold text-xs text-zinc-700 dark:text-stone-300">{{ count($attendances) }}</span>
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
                    <th class="px-2 py-1 text-left w-96">{{ __('messages.models.activity_attendance.person') }}</th>
                    <th class="px-2 py-1 text-left w-96">{{ __('messages.models.activity_attendance.state') }}</th>
                    <th class="px-2 py-1 text-left w-96">{{ __('messages.models.activity_attendance.attendance_date') }}</th>
                    <th class="px-2 py-1 text-left w-60">{{ __('messages.data.dates') }}</th>
                    <th class="px-2 py-1 w-60"></th>
                </tr>
                </thead>
                {{-- body --}}
                <tbody>
                @foreach ($attendances as $item)

                    <tr class="border-b border-b-blue-300 dark:border-b-slate-500 bg-white dark:bg-slate-600 hover:bg-blue-100 dark:hover:bg-slate-500 dark:text-stone-50 dark:hover:text-white hover:shadow transition ease-in-out duration-300">

                        {{-- id event --}}
                        <td class="p-2 text-center">{{ $item->id }}</td>
                        {{-- person name --}}
                        <td class="p-2 text-left">
                            <span class="font-bold text-sm">{{ $item->person->getFullName() }}</span>
                        
                        </td>

                        {{-- status --}}
                        <td class="p-2 text-left">
                            <span class="font-bold text-sm">{{ __($item->get_state('key_name')) }}</span>
                        </td>

                        {{-- attendance_date --}}
                        <td class="p-2 text-left">
                            <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $item->attendance_date ? \Illuminate\Support\Carbon::createFromTimeString($item->attendance_date)->format('d M Y h:i a') : __('messages.data.unregistered') }}</span>
                        </td>
              
                        </td>
                        {{-- dates --}}
                        <td class="p-2 text-left">
                            <x-tables.dates-columns :created_at="$item->created_at" :updated_at="$item->updated_at"/>
                        </td>
                        {{-- actions --}}
                        <td>
                            <div class="inline-flex items-center space-x-1">
                                {{-- edit --}}
                                @ability('*', 'activity_attendances:edit')
                                <x-buttons.circle-icon-button wire:click="openEditModal({{ $item }})" title="Click para editar este registro" color="violet" size="20px">edit</x-buttons.circle-icon-button>
                                @endability
                                {{-- delete --}}
                                @ability('*', 'activity_attendances:delete')
                                <x-buttons.circle-icon-button wire:click="openDeleteModal({{ $item }})" title="Click para eliminar este registro" color="red" size="20px">delete</x-buttons.circle-icon-button>
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
    <livewire:sys.activities.attendances.attendance-form/>
    {{-- event-delete --}}
    <livewire:sys.activities.attendances.attendance-delete/>

</div>
