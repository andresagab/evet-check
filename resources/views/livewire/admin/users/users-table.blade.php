<div wire:init="search(true, true)">

    {{-- full-page-loader --}}
    <x-loaders.full-page-loader wire:loading wire:target='search, openAddModal, openEditModal, openDeleteModal, open_manage_role_permissions'/>

    {{-- sub header --}}
    <x-layouts.headers.sub-header title="{{ __('messages.menu.users') }}" :actions="true">

        {{-- add button --}}
        @ability('*', 'users:add')
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
                            <label class="font-semibold text-sm text-zinc-900 dark:text-stone-100" for="filters.name">{{ __('messages.models.user.name') }}:</label>
                            <input wire:model.defer="filters.name" wire:keydown.enter='search(true, true)' type="text" name="filters.name" id="filters.name" placeholder="{{ __('messages.models.user.inputs.name') }}" class="dark:border-none border-slate-700 px-2 py-1 text-sm w-full bg-white-200 dark:bg-slate-900 dark:text-stone-200 rounded-md">
                        </div>

                        {{-- filters.code --}}
                        <div class="flex flex-col items-start w-full">
                            <label class="font-semibold text-sm text-zinc-900 dark:text-stone-100" for="filters.code">{{ __('messages.models.user.code') }}:</label>
                            <input wire:model.defer="filters.code" wire:keydown.enter='search(true, true)' type="text" name="filters.code" id="filters.code" placeholder="{{ __('messages.models.user.inputs.code') }}" class="dark:border-none border-slate-700 px-2 py-1 text-sm w-full bg-white-200 dark:bg-slate-900 dark:text-stone-200 rounded-md">
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
                        <span class="font-semibold text-xs text-zinc-700 dark:text-stone-300">{{ count($users) }}</span>
                    </div>
                    {{-- per_page --}}
                    <div class="flex flex-row items-center space-x-1 select-none">
                        <label class="font-semibold text-xs text-zinc-900 dark:text-stone-100" for="pagination.per_page">Registros por página:</label>
                        <select wire:model.defer="pagination.per_page" name="pagination.per_page" id="pagination.per_page" class="dark:border-none border-slate-700 bg-white dark:bg-slate-900 dark:text-stone-300 text-xs font-zinc-700 rounded-md p-0.5 w-16">
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
                    <th class="px-2 py-1 text-left w-96">{{ __('messages.models.user.name') }}</th>
                    <th class="px-2 py-1 text-left w-48">{{ __('messages.models.user.code') }}</th>
                    <th class="px-2 py-1 text-left w-48">{{ __('messages.models.role.name') }}</th>
                    <th class="px-2 py-1 text-center w-48">{{ __('messages.models.user.state') }}</th>
                    <th class="px-2 py-1 text-left w-60">{{ __('messages.data.dates') }}</th>
                    <th class="px-2 py-1 w-60"></th>
                </tr>
                </thead>
                {{-- body --}}
                <tbody>
                @foreach ($users as $item)

                    {{-- php code --}}
                    @php
                        # get state reference
                        $state = $item->getState();
                        # get role
                        $role = $item->getRole();
                    @endphp

                    <tr class="border-b border-b-blue-300 dark:border-b-slate-500 bg-white dark:bg-slate-600 hover:bg-blue-100 dark:hover:bg-slate-500 dark:text-stone-50 dark:hover:text-white hover:shadow transition ease-in-out duration-300">

                        {{-- full name --}}
                        <td class="p-2">
                            <div class="flex flex-row items-center space-x-3">
                                <img src="{{ $item->getProfilePhoto() }}" class="w-16 h-16 rounded-full shadow bg-stone-100 bg-auto object-contain hover:scale-110 transition ease-in-out duration-300">
                                <div class="flex flex-col items-start">
                                    <span class="font-semibold text-sm">{{ $item->name }}</span>
                                    <span class="font-normal text-xs text-gray-700 dark:text-stone-200 italic">#{{ $item->id }}</span>
                                </div>
                            </div>
                        </td>
                        {{-- code --}}
                        <td class="p-2 font-normal text-sm">{{ $item->code }}</td>
                        {{-- role --}}
                        <td class="p-2 font-normal text-sm">{{ $role ? $role->display_name : __('unregister') }}</td>
                        {{-- state --}}
                        <td class="p-2 text-center">
                            <x-utils.cheap :color="$state['color']" class="text-sm font-semibold">{{ app()->getLocale() === 'es' ? $state['es_name'] : $state['en_name'] }}</x-utils.cheap>
                        </td>
                        {{-- dates --}}
                        <td class="p-2 text-left">
                            <x-tables.dates-columns :created_at="$item->created_at" :updated_at="$item->updated_at"/>
                        </td>
                        {{-- actions --}}
                        <td>
                            <div class="inline-flex items-center space-x-1">
                                {{-- edit --}}
                                @ability('*', 'users:edit')
                                    <x-buttons.circle-icon-button wire:click="openEditModal({{ $item }})" title="Click para editar este registro" color="violet" size="20px">edit</x-buttons.circle-icon-button>
                                @endability
                                {{-- delete --}}
                                @if($item->can_delete() && Laratrust::ability('*', 'users:delete'))
                                    <x-buttons.circle-icon-button wire:click="openDeleteModal({{ $item }})" title="Click para eliminar este registro" color="red" size="20px">delete</x-buttons.circle-icon-button>
                                @endif
                                {{-- manage-user-permissions --}}
                                @if($item->state === 'A' && Laratrust::ability('*', 'users:manage-permissions'))
                                    <x-buttons.circle-icon-button wire:click="open_manage_role_permissions({{ $item }})" title="Click para gestionar los permisos de este registro" color="emerald" size="20px">manage_accounts</x-buttons.circle-icon-button>
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

    {{-- user-form --}}
    <livewire:admin.users.user-form/>
    {{-- user-delete --}}
    <livewire:admin.users.user-delete/>
    {{-- manage-user-permissions --}}
    <livewire:admin.users.manage-user-permissions/>

</div>
