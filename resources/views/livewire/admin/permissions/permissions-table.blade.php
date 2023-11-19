<div wire:init="search(true, true)">

    {{-- full-page-loader --}}
    <x-loaders.full-page-loader wire:loading wire:target='search, openAddModal, openEditModal, openDeleteModal'/>

    {{-- sub header --}}
    <x-layouts.headers.sub-header title="{{ __('messages.menu.permissions') }}" :actions="true">

        {{-- add button --}}
        @ability('*', 'permissions:add')
            <x-buttons.circle-icon-button wire:click="openAddModal" wire.offline="disabled" wire:loading.class="hidden" color="green">add</x-buttons.circle-icon-button>
        @endability

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

                        {{-- filters.permission --}}
                        <div class="flex flex-col items-start w-full">
                            <label class="font-semibold text-sm text-zinc-900 dark:text-stone-100" for="filters.name">{{ __('messages.models.permission.name') }}:</label>
                            <input wire:model.defer="filters.name" wire:keydown.enter='search(true, true)' type="text" name="filters.name" id="filters.name" placeholder="{{ __('messages.models.permission.inputs.name') }}" class="border-none px-2 py-1 text-sm w-full bg-white-200 dark:bg-slate-900 dark:text-stone-200 rounded-md">
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
                        <span class="font-semibold text-xs text-zinc-700 dark:text-stone-300">{{ count($permissions) }}</span>
                    </div>
                    {{-- per_page --}}
                    <div class="flex flex-row items-center space-x-1 select-none">
                        <label class="font-semibold text-xs text-zinc-900 dark:text-stone-100" for="pagination.per_page">Registros por página:</label>
                        <select wire:model.defer="pagination.per_page" name="pagination.per_page" id="pagination.per_page" class="border-none bg-white dark:bg-slate-900 dark:text-stone-300 text-xs font-zinc-700 rounded-md p-0.5 w-16">
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
                    <th class="px-2 py-1 text-left w-96">{{ __('messages.models.permission.name') }}</th>
                    <th class="px-2 py-1 text-left w-96">{{ __('messages.models.permission.display_name') }}</th>
                    <th class="px-2 py-1 text-left w-96">{{ __('messages.models.permission.module') }}</th>
                    <th class="px-2 py-1 text-left w-96">{{ __('messages.models.permission.description') }}</th>
                    <th class="px-2 py-1 text-left w-96">{{ __('messages.data.dates') }}</th>
                    <th class="px-2 py-1 w-60"></th>
                </tr>
                </thead>
                {{-- body --}}
                <tbody>
                @foreach ($permissions as $item)

                    {{-- php code --}}
                    @php
                        # load module of current permission
                        $module = $item->get_module();
                        # define module color
                        $module_color = $module ? $module['color'] : 'gray';
                    @endphp

                    <tr class="border-b border-b-blue-300 dark:border-b-slate-500 bg-white dark:bg-slate-600 hover:bg-blue-100 dark:hover:bg-slate-500 dark:text-stone-50 dark:hover:text-white hover:shadow transition ease-in-out duration-300">
                        {{-- id --}}
                        <td class="p-2 text-center">{{ $item->id }}</td>
                        {{-- name --}}
                        <td class="p-2">
                            <span class="font-medium text-sm">{{ $item->name ?? __('messages.data.unknown') }}</span>
                        </td>
                        {{-- display_name --}}
                        <td class="p-2">
                            <span class="font-semibold text-sm">{{ $item->display_name ?? __('messages.data.unknown') }}</span>
                        </td>
                        {{-- module --}}
                        <td class="p-2">
                            <x-utils.cheap :color="$module_color" class="font-semibold select-none text-sm">{{ $module ? __($module['translate_key']) : 'messages.data.unknown' }}</x-utils.cheap>
                        </td>
                        {{-- description --}}
                        <td class="p-2">
                            <span class="font-normal text-sm">{{ $item->description ?? __('messages.data.unknown') }}</span>
                        </td>
                        {{-- dates --}}
                        <td class="p-2 text-left">
                            <x-tables.dates-columns :created_at="$item->created_at" :updated_at="$item->updated_at"/>
                        </td>
                        {{-- actions --}}
                        <td>
                            <div class="inline-flex items-center space-x-1">
                                {{-- is editable or removable --}}
                                @if($item->is_editable_or_removable())
                                    {{-- edit --}}
                                    @ability('*', 'permissions:edit')
                                        <x-buttons.circle-icon-button wire:click="openEditModal({{ $item }})" title="Click para editar este registro" color="violet" size="20px">edit</x-buttons.circle-icon-button>
                                    @endability
                                    {{-- delete --}}
                                    @ability('*', 'permissions:delete')
                                    {{-- pending add validation for check if the resource can be deleted --}}
                                    <x-buttons.circle-icon-button wire:click="openDeleteModal({{ $item }})" title="Click para eliminar este registro" color="red" size="20px">delete</x-buttons.circle-icon-button>
                                    @endability
                                @else
                                    {{-- locked icon --}}
                                    <x-utils.icon size="20px" class="p-1 text-stone-700 dark:text-zinc-300 select-none" title="{{ __('messages.data.not_editable_removable') }}">lock</x-utils.icon>
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

    {{-- permission-form --}}
    <livewire:admin.permissions.permission-form/>
    {{-- permission-delete --}}
    <livewire:admin.permissions.permission-delete/>
</div>
