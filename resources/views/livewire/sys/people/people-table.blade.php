<div wire:init="search(true, true)">

    {{-- full-page-loader --}}
    <x-loaders.full-page-loader wire:loading wire:target='search, openAddModal, openEditModal, openDeleteModal, open_manage_role_permissions'/>

    {{-- sub header --}}
    <x-layouts.headers.sub-header title="{{ __('messages.menu.people') }}" :actions="true">

        {{-- add button --}}
        @ability('*', 'people:add')
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
                            <label class="font-semibold text-sm text-zinc-900 dark:text-stone-100" for="filters.name">{{ __('messages.models.person.names_surnames') }}:</label>
                            <input wire:model.defer="filters.name" wire:keydown.enter='search(true, true)' type="text" name="filters.name" id="filters.name" placeholder="{{ __('messages.models.person.filters.person') }}" class="border-none px-2 py-1 text-sm w-full bg-white-200 dark:bg-slate-900 dark:text-stone-200 rounded-md">
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
                        <span class="font-semibold text-xs text-zinc-700 dark:text-stone-300">{{ count($people) }}</span>
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
                    <th class="px-2 py-1 text-left w-96">{{ __('messages.models.person.model_name') }}</th>
                    <th class="px-2 py-1 text-left w-32">{{ __('messages.models.user.model_name') }}</th>
                    <th class="px-2 py-1 text-left w-48">{{ __('messages.models.person.contact') }}</th>
                    <th class="px-2 py-1 text-left w-60">{{ __('messages.data.dates') }}</th>
                    <th class="px-2 py-1 w-60"></th>
                </tr>
                </thead>
                {{-- body --}}
                <tbody>
                @foreach ($people as $item)

                    {{-- php code --}}
                    @php
                        # get state reference
                        $state = $item->user->getState();
                        # get role
                        $role = $item->user->getRole();
                    @endphp

                    <tr class="border-b border-b-blue-300 dark:border-b-slate-500 bg-white dark:bg-slate-600 hover:bg-blue-100 dark:hover:bg-slate-500 dark:text-stone-50 dark:hover:text-white hover:shadow transition ease-in-out duration-300">

                        {{-- id person --}}
                        <td class="p-2 text-center">{{ $item->id }}</td>
                        {{-- person info --}}
                        <td class="p-2">
                            <div class="flex flex-row items-center space-x-3">
                                {{-- profile photo --}}
                                <img src="{{ $item->user->getProfilePhoto() }}" class="w-16 h-16 rounded-full shadow bg-stone-100 bg-auto object-contain hover:scale-110 transition ease-in-out duration-300">
                                {{-- person data --}}
                                <div class="flex flex-col items-start">
                                    {{-- full name --}}
                                    <span class="font-bold text-sm">{{ $item->getFullName() }}</span>
                                    {{-- nuip --}}
                                    <span class="font-normal text-xs text-gray-800 dark:text-stone-200 italic" title="{{ __('messages.models.person.nip') }}">#{{ $item->nuip }}</span>
                                </div>
                            </div>
                        </td>
                        {{-- user info --}}
                        <td class="p-2">
                            {{-- data --}}
                            <div class="flex flex-col items-start">
                                {{-- name --}}
                                <span class="font-bold text-sm">{{ $item->user->name }}</span>
                                {{-- code --}}
                                <span class="font-normal text-xs text-gray-800 dark:text-stone-200 italic" title="{{ __('messages.models.user.code') }}">#{{ $item->user->code }}</span>
                                {{-- role --}}
                                <span class="font-normal text-xs text-gray-800 dark:text-stone-300" title="{{ __('messages.models.user.role') }}">{{ $item->user->getRole()->display_name }}</span>
                                {{-- state --}}
                                <x-utils.cheap :color="$state['color']" class="text-xs font-semibold">{{ app()->getLocale() === 'es' ? $state['es_name'] : $state['en_name'] }}</x-utils.cheap>
                            </div>
                        </td>
                        {{-- contact info --}}
                        <td class="p-2 text-left">
                            <div class="flex flex-col items-start space-y-1">

                                {{-- cell_phone --}}
                                <div class="inline-flex items-center space-x-1">
                                    <x-utils.icon class="text-orange-700 dark:text-orange-500">smartphone</x-utils.icon>
                                    <span class="font-normal text-sm text-gray-900 dark:text-stone-100">{{ strlen($item->cel) > 0 ? $item->cel : __('messages.data.unregistered') }}</span>
                                </div>
                                {{-- phone --}}
                                @if($item->phone)
                                    <div class="inline-flex items-center space-x-1">
                                        <x-utils.icon class="text-lime-600 dark:text-lime-300">call</x-utils.icon>
                                        <span class="font-normal text-sm text-gray-900 dark:text-stone-100">{{ strlen($item->phone) > 0 ? $item->phone : __('messages.data.unregistered') }}</span>
                                    </div>
                                @endif
                                {{-- email --}}
                                <div class="inline-flex items-center space-x-1">
                                    <x-utils.icon class="text-sky-600 dark:text-sky-300">mail</x-utils.icon>
                                    <span class="font-normal text-sm text-gray-900 dark:text-stone-100">{{ strlen($item->email) > 0 ? $item->email : __('messages.data.unregistered') }}</span>
                                </div>

                            </div>
                        </td>
                        {{-- dates --}}
                        <td class="p-2 text-left">
                            <x-tables.dates-columns :created_at="$item->created_at" :updated_at="$item->updated_at"/>
                        </td>
                        {{-- actions --}}
                        <td>
                            <div class="inline-flex items-center space-x-1">
                                {{-- edit --}}
                                @ability('*', 'people:edit')
                                    <x-buttons.circle-icon-button wire:click="openEditModal({{ $item }})" title="Click para editar este registro" color="violet" size="20px">edit</x-buttons.circle-icon-button>
                                @endability
                                {{-- delete --}}
                                @if($item->can_delete() && Laratrust::ability('*', 'people:delete'))
                                    <x-buttons.circle-icon-button wire:click="openDeleteModal({{ $item }})" title="Click para eliminar este registro" color="red" size="20px">delete</x-buttons.circle-icon-button>
                                @endif
                                {{-- manage-person-permissions --}}
                                @if($item->user->state === 'A' && Laratrust::ability('*', 'users:manage-permissions'))
                                    <x-buttons.circle-icon-button wire:click="open_manage_role_permissions({{ $item->user }})" title="Click para gestionar los permisos de este registro" color="emerald" size="20px">manage_accounts</x-buttons.circle-icon-button>
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

    {{-- person-form --}}
    <livewire:sys.people.person-form/>
    {{-- person-delete --}}
    <livewire:sys.people.person-delete/>
    {{-- manage-person-permissions --}}
    <livewire:admin.users.manage-user-permissions/>

</div>
