<div wire:init="search(true, true)">

    {{-- full-page-loader --}}
    <x-loaders.full-page-loader wire:loading wire:target='search, openAddModal, openEditModal, openDeleteModal'/>

    {{-- sub header --}}
    <x-layouts.headers.sub-header title="{{ __('messages.menu.event_attendances') }} | {{ $event->name }}" :actions="true">

        {{-- add button --}}
        @ability('*', 'event_attendances:add')
        <x-buttons.circle-icon-button wire:click="openAddModal" wire.offline="disabled" wire:loading.class="hidden" color="green">add</x-buttons.circle-icon-button>
        @endability

        {{-- import button --}}
        @ability('*', 'event_attendances:add')
        <x-buttons.circle-icon-button wire:click="openImportModal" wire.offline="disabled" wire:loading.class="hidden" color="teal" title="Importar participantes">upload_file</x-buttons.circle-icon-button>
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
                            <label class="font-semibold text-sm text-zinc-900 dark:text-stone-100" for="filters.name">{{ __('messages.models.event_attendance.person') }}:</label>
                            <input wire:model="filters.name" wire:keydown.enter='search(true, true)' type="text" name="filters.name" id="filters.name" placeholder="{{ __('messages.models.event_attendance.filters.person') }}" class="border-none px-2 py-1 text-sm w-full bg-white-200 dark:bg-slate-900 dark:text-stone-200 rounded-md">
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
                    <th class="px-2 py-1 text-left w-96">{{ __('messages.models.event_attendance.person') }}</th>
                    <th class="px-2 py-1 text-left w-96">{{ __('messages.models.event_attendance.institution') }}</th>
                    <th class="px-2 py-1 text-left w-72">{{ __('messages.models.event_attendance.attendance') }}</th>
                    <th class="px-2 py-1 text-left w-36">{{ __('messages.models.event_attendance.statuses') }}</th>
                    <th class="px-2 py-1 text-left w-44">{{ __('messages.models.event_attendance.activities_info') }}</th>
                    <th class="px-2 py-1 text-left w-60">{{ __('messages.data.dates') }}</th>
                    <th class="px-2 py-1 w-60"></th>
                </tr>
                </thead>
                {{-- body --}}
                <tbody>
                @foreach ($attendances as $item)

                    {{-- php code --}}
                    @php
                        # load state reference
                        $payment_status = $item->get_payment_status();
                        # load certificate status
                        $certificate_status = $item->get_certificate_status();
                        # load approve certificate manually status
                        $manually_status = $item->get_approve_certificate_manually_status();
                    @endphp

                    <tr class="border-b border-b-blue-300 dark:border-b-slate-500 bg-white dark:bg-slate-600 hover:bg-blue-100 dark:hover:bg-slate-500 dark:text-stone-50 dark:hover:text-white hover:shadow transition ease-in-out duration-300">

                        {{-- id event --}}
                        <td class="p-2 text-center">{{ $item->id }}</td>
                        {{-- person name --}}
                        <td class="p-2 text-left">
                            <div class="flex flex-col items-start">
                                <span class="font-bold dark:text-white text-sm">{{ $item->person->getFullName() }}</span>
                                <span class="font-normal dark:text-slate-300 text-xs italic">{{ $item->person->nuip }}</span>
                            </div>
                        </td>
                        {{-- institution --}}
                        <td class="p-2 text-left">
                            <span class="font-semibold text-sm">{{ $item->get_institution() }}</span>
                        </td>
                        {{-- attendance --}}
                        <td class="p-2 text-left">
                            <div class="flex flex-col">
                                {{-- participation_modality --}}
                                <div class="inline-flex items-center justify-start space-x-2" title="{{ __('messages.models.event_attendance.participation_modality') }}">
                                    <x-utils.icon class="text-{{ $item->get_participation_modality('color') }}-600 dark:text-{{ $item->get_participation_modality('color') }}-500 select-none" size="16px">groups</x-utils.icon>
                                    <span class="font-bold">{{ __($item->get_participation_modality('key_name')) }}</span>
                                </div>
                                {{-- type --}}
                                <div class="inline-flex items-center justify-start space-x-2" title="{{ __('messages.models.event_attendance.type') }}">
                                    <x-utils.icon class="text-green-600 dark:text-green-500 select-none" size="16px">recent_actors</x-utils.icon>
                                    <span class="font-normal italic">{{ __($item->get_type()) }}</span>
                                </div>
                                {{-- stay_type --}}
                                <div class="inline-flex items-center justify-start space-x-2" title="{{ __('messages.models.event_attendance.stay_type') }}">
                                    <x-utils.icon class="text-pink-600 dark:text-pink-500 select-none" size="16px">hail</x-utils.icon>
                                    <span class="font-normal text-xs">{{ __($item->get_stay_type()) }}</span>
                                </div>
                            </div>
                        </td>
                        {{-- statuses --}}
                        <td class="p-2 text-left">
                            <div class="flex flex-col space-y-2">
                                {{-- payment statuse --}}
                                <div class="inline-flex items-center justify-start space-x-2" title="Estado de pago">
                                    <x-utils.icon class="text-{{ $payment_status['color'] }}-sky dark:text-{{ $payment_status['color'] }}-500 select-none" size="16px">attach_money</x-utils.icon>
                                    <span class="font-bold text-sm text-{{ $payment_status['color'] }}-700 dark:text-{{ $payment_status['color'] }}-300">{{ __($payment_status['key_name']) }}</span>
                                </div>
                                {{-- certified status --}}
                                <div class="inline-flex items-center justify-start space-x-2" title="Estado de certificación">
                                    <x-utils.icon class="text-{{ $certificate_status['color'] }}-sky dark:text-{{ $certificate_status['color'] }}-500 select-none" size="16px">verified</x-utils.icon>
                                    <span class="font-bold text-sm text-{{ $certificate_status['color'] }}-700 dark:text-{{ $certificate_status['color'] }}-300">{{ __($certificate_status['full_name']) }}</span>
                                </div>
                                {{-- approve certify manually status --}}
                                <div class="inline-flex items-center justify-start space-x-2" title="Certificado aprobado manualmente">
                                    <x-utils.icon class="text-{{ $manually_status['color'] }}-sky dark:text-{{ $manually_status['color'] }}-500 select-none" size="16px">shield</x-utils.icon>
                                    <span class="font-normal italic text-sm text-{{ $manually_status['color'] }}-700 dark:text-{{ $manually_status['color'] }}-300">{{ __($manually_status['full_name']) }}</span>
                                </div>
                            </div>
                        </td>
                        {{-- activities info --}}
                        <td class="p-2 text-center">
                            <div class="flex flex-col">
                                {{-- registered activities --}}
                                <div class="inline-flex items-center justify-start space-x-2" title="Actividades inscritas">
                                    <x-utils.icon class="text-lime-sky dark:text-sky-500 select-none" size="16px">subscriptions</x-utils.icon>
                                    <span class="font-bold">{{ $item->get_activities_by_state(data: false) }}</span>
                                </div>
                                {{-- done activities --}}
                                <div class="inline-flex items-center justify-start space-x-2" title="Actividades realizadas">
                                    <x-utils.icon class="text-lime-600 dark:text-lime-500 select-none" size="16px">fact_check</x-utils.icon>
                                    <span class="font-bold">{{ $item->person->get_total_activities_attendance($item->event_id) }}</span>
                                </div>
                                {{-- unregistered activities --}}
                                <div class="inline-flex items-center justify-start space-x-2" title="Actividades no realizadas">
                                    <x-utils.icon class="text-rose-600 dark:text-rose-500 select-none" size="16px">event_busy</x-utils.icon>
                                    <span class="font-bold">{{ $item->get_activities_by_state('DO', false) }}</span>
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
                                @ability('*', 'event_attendances:edit')
                                <x-buttons.circle-icon-button wire:click="openEditModal({{ $item }})" title="Click para editar este registro" color="violet" size="20px">edit</x-buttons.circle-icon-button>
                                @endability
                                {{-- delete --}}
                                @ability('*', 'event_attendances:delete')
                                <x-buttons.circle-icon-button wire:click="openDeleteModal({{ $item }})" title="Click para eliminar este registro" color="red" size="20px">delete</x-buttons.circle-icon-button>
                                @endability
                                {{-- set_as_paid --}}
                                @if($item->payment_status === 'NP' && Laratrust::ability('*', 'event_attendances:set_as_paid'))
                                <x-buttons.circle-icon-button wire:click="set_as_paid({{ $item }})" wire:confirm="Por favor confirma esta acción" title="Registrar el cobro simbólico como pagado" color="green" size="20px">price_check</x-buttons.circle-icon-button>
                                @endif
                                {{-- approve_certificate_manually --}}
                                @if(Laratrust::ability('*', 'event_attendances:set_approve_certificate_manually'))
                                    {{-- if approve certificate manually is true --}}
                                    @if($item->approve_certificate_manually)
                                        {{-- not approve button --}}
                                        <x-buttons.circle-icon-button wire:click="set_approve_certificate_manually({{ $item }})" wire:confirm="Por favor confirma que vas a marcar este registro como: 'Certificado no aprobado manualmente'" title="No aprobar certificado manualmente" color="rose" size="20px">remove_moderator</x-buttons.circle-icon-button>
                                    @else
                                        {{-- not approve button --}}
                                        <x-buttons.circle-icon-button wire:click="set_approve_certificate_manually({{ $item }})" wire:confirm="Por favor confirma que vas a marcar este registro como: 'Certificado aprobado manualmente'" title="Aprobar certificado manualmente" color="lime" size="20px">verified_user</x-buttons.circle-icon-button>
                                    @endif
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

    {{-- event-form --}}
    <livewire:sys.events.attendances.attendance-form/>
    {{-- event-delete --}}
    <livewire:sys.events.attendances.attendance-delete/>
    {{-- import-attendances --}}
    <livewire:sys.events.attendances.import-attendances/>

</div>
