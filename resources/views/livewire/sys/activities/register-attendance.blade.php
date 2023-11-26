<div>

    <x-modals.modal-dialog wire:model='open' includeFooter="0">
        <!-- modal title -->
        <x-slot:title>
            <div class="flex flex-row items-center">
                <h3 class="flex-grow font-bold text-lg uppercase text-purple-800 dark:text-purple-300 select-none">{{ __("messages.data.actions.add", ['resource' => __('messages.models.activity_attendance.model_name')]) }}</h3>
                <x-buttons.circle-icon-button color="red" title="Click para cerrar" wire:click="$toggle('open')">close</x-buttons.circle-icon-button>
            </div>
        </x-slot:title>
        <hr class="mt-1">
        <!-- modal body -->
        <x-slot:content>
            {{-- section-loader --}}
            <x-loaders.section-loader wire:loading/>

            {{-- main layer --}}
            <div class="flex flex-col items-center space-y-6 w-full">

                {{-- if attendance have id --}}
                @if($activity->id)

                    {{-- activity --}}
                    <x-sys.activities.info-card :activity="$activity" bg_dark_color="slate-700"/>

                @endif

                {{-- person form --}}
                <x-cards.card title="Buscador" :footer="0" color="stone-100">
                    <x-slot:content>

                        {{-- person searcher --}}
                        <x-forms.input-group class="w-full mb-2">
                            {{-- label --}}
                            <x-forms.label value="{{ __('Buscar asistente:') }}" for="person.names"/>
                            {{-- input --}}
                            <div class="w-full flex flex-row space-x-2 items-center">
                                {{-- custom input --}}
                                <input type="text" id="filters.person" wire:model="filters.person" wire:keyup.enter="search_people" maxlength="250" placeholder="{{ __('messages.models.person.filters.person') }}" class="px-2 py-1 text-sm w-full bg-white-200 dark:bg-gray-900 rounded-md focus:outline-none focus:border focus:border-indigo-700 font-normal text-gray-900 dark:text-stone-100 appearance-none transition ease-in-out duration-300"
                                       @if($person->id) readonly disabled @endif autocomplete="off"
                                >
                                {{-- if person model not have id --}}
                                @if(!$person->id)
                                    {{-- search button --}}
                                    <x-buttons.circle-icon-button wire:click="search_people" color="blue" title="Click para buscar">search</x-buttons.circle-icon-button>
                                {{-- else, person model have id --}}
                                @else
                                    {{-- remove person button --}}
                                    <x-buttons.circle-icon-button wire:click="remove_person" color="red" title="Click para quitar a la persona seleccionada">remove</x-buttons.circle-icon-button>
                                @endif
                            </div>
                            {{-- if people collection have data and a person is not selected --}}
                            @if(count($people) > 0 && !$person->id)
                                <div class="flex flex-col w-full max-h-56 bg-white dark:bg-slate-950 divide-y divide-slate-500 overflow-y-auto">
                                    @foreach($people as $item)
                                        <div wire:click="select_person({{ $item }})" class="flex flex-col p-2 dark:hover:bg-slate-800 transition ease-in-out duration-300 cursor-pointer" title="Click para seleccionar">
                                            {{-- names --}}
                                            <span class="font-semibold text-sm dark:text-white">{{ $item->getFullName() }}</span>
                                            {{-- dni --}}
                                            <span class="font-normal italic text-sm dark:text-slate-300">{{ $item->nuip }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            {{-- error --}}
                            <x-forms.error for="filters.person"/>
                        </x-forms.input-group>

                        {{--<x-sys.activities.attendances.data-card :attendance="$attendance"/>--}}

                        {{-- button --}}

                    </x-slot:content>
                </x-cards.card>

                {{-- if person was loaded --}}
                @if($person->id)
                    <x-sys.people.data-card :person="$person"/>
                @endif

                {{-- attendance data-card --}}
                @if($attendance->id)

                    {{-- php code --}}
                    @php
                        # load attendance state
                        $state = $attendance->get_state();
                    @endphp

                    <x-cards.card title="Datos de Inscripción" color="slate-900" :footer="0">
                        <x-slot:content>
                            {{-- id --}}
                            <div class="inline-flex items-center space-x-1 px-1.5">
                                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">ID:</span>
                                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $attendance->id }}</span>
                            </div>
                            {{-- state --}}
                            <div class="inline-flex items-center space-x-1 px-1.5">
                                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.activity_attendance.state') }}:</span>
                                <span class="font-bold text-{{ $state['color'] }}-700 dark:text-{{ $state['color'] }}-400 text-sm">{{ __($state['key_name']) }}</span>
                            </div>
                            {{-- attendance_date --}}
                            <div class="inline-flex items-center space-x-1 px-1.5">
                                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.activity_attendance.attendance_date') }}:</span>
                                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $attendance->attendance_date ? \Illuminate\Support\Carbon::createFromTimeString($attendance->attendance_date)->format('d M Y h:i a') : __('messages.data.unregistered') }}</span>
                            </div>
                            {{-- created_at --}}
                            <div class="inline-flex items-center space-x-1 px-1.5">
                                <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.activity_attendance.created_at') }}:</span>
                                <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $attendance->created_at ? \Illuminate\Support\Carbon::createFromTimeString($attendance->created_at)->format('d M Y h:i a') : __('messages.data.unregistered') }}</span>
                            </div>
                        </x-slot:content>
                    </x-cards.card>
                @elseif(!$attendance->id && $person->id)
                    <span class="text-red-500 dark:text-red-400 font-bold text-sm">¡Esta persona no está inscrita en esta actividad!</span>
                @endif

                {{-- action buttons --}}
                <div class="w-full inline-flex space-x-2 items-center justify-end mt-5">
                    {{-- cancel button --}}
                    <x-buttons.secondary-button wire:click="$toggle('open')" type="button" color="red">Cancelar</x-buttons.secondary-button>
                    {{-- save button --}}
                    @if($person->id && $attendance->id && $attendance->state === 'SU')
                        <x-buttons.main-button wire:click="register_attendance" type="button">Registrar Asistencia</x-buttons.main-button>
                    @endif
                </div>

            </div>
        </x-slot:content>

    </x-modals.modal-dialog>

</div>
