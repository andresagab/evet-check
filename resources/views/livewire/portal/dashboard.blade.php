<div class="w-full min-h-screen bg-slate-900">

    {{-- full-page-loader --}}
    <x-loaders.full-page-loader wire:loading/>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">

        {{-- page title --}}
        <header class="text-center">
            <h1 class="font-bold text-3xl md:text-5xl text-white">EVENTOS INSCRITOS</h1>
            <p class="mt-4 text-lg md:text-xl text-slate-400">{{ $person->getFullName() }}</p>
            <div class="mt-6">
                <x-buttons.main-button wire:click="open_register_event_attendance_modal" color="teal" class="px-6 py-3 rounded-lg font-semibold">
                    Inscribirme a un evento
                </x-buttons.main-button>
            </div>
        </header>

        {{-- events --}}
        <div class="mt-12 max-w-3xl mx-auto space-y-6">
            @if(count($attendances) > 0)
                @foreach($attendances as $item)
                    <article class="bg-slate-800 border border-slate-700 rounded-xl shadow-lg overflow-hidden transition-transform transform hover:-translate-y-1 duration-300">
                        <div class="p-6">
                            {{-- head card info --}}
                            <header class="flex justify-between items-start gap-4">
                                <div class="flex-grow">
                                    <h3 class="text-xl font-bold text-white break-words">{{ $item->event->name }}</h3>
                                    <p class="text-amber-400 text-sm mt-1">{{ __($item->get_participation_modality('key_name')) }}</p>
                                </div>
                                <div class="bg-slate-700 text-slate-300 text-sm font-semibold px-3 py-1 rounded-full flex-shrink-0">
                                    {{ $item->event->year }}
                                </div>
                            </header>

                            {{-- info --}}
                            <div class="mt-4 border-t border-slate-700 pt-4">
                                <div class="flex justify-between items-center text-center">
                                    <div>
                                        <p class="text-sm text-slate-400">Actividades</p>
                                        <p class="text-lg font-bold text-white">{{ $item->event->activities->count() }}</p>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <p class="text-sm text-slate-400">Realizadas</p>
                                        <p class="text-lg font-bold text-green-400">{{ $person->get_total_activities_attendance($item->event_id) }}</p>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <p class="text-sm text-slate-400">Pendientes</p>
                                        <p class="text-lg font-bold text-red-400">{{ $item->get_activities_by_state('DO', false) }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- actions --}}
                            <footer class="mt-6">
                                @if($item->event->state != 'CP')
                                    <div class="flex justify-end space-x-3">
                                        <x-buttons.main-button wire:click="open_virtual_card({{ $item->event }})" color="violet" class="px-4 py-2 rounded-md text-sm font-medium">Carnet Virtual</x-buttons.main-button>
                                        <x-buttons.main-button wire:click="open_activities({{ $item->event }})" color="sky" class="px-4 py-2 rounded-md text-sm font-medium">Actividades</x-buttons.main-button>
                                    </div>
                                @else
                                    <div class="flex justify-end items-center">
                                        @if($item->can_get_certificate())
                                            <x-buttons.main-button wire:click="generate_certificate({{ $item }})" color="indigo" class="px-4 py-2 rounded-md text-sm font-medium">Descargar Certificado</x-buttons.main-button>
                                        @else
                                            <p class="text-red-400 italic text-sm text-right">No puedes acceder al certificado porque no cumples con los requisitos mínimos.</p>
                                        @endif
                                    </div>
                                @endif
                            </footer>
                        </div>
                    </article>
                @endforeach
            {{-- else, then show custom info message --}}
            @else
                <div class="bg-slate-800 border border-slate-700 rounded-lg p-8 text-center">
                    <p class="font-medium text-lg text-slate-300">No tienes eventos inscritos.</p>
                    <p class="text-sm text-slate-500 mt-2">Por favor realiza la inscripción o comunícate con los organizadores del evento para mayor información.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- components --}}

    {{-- register-event-attendance --}}
    <livewire:portal.register-event-attendance/>

</div>
