<div class="w-full min-h-screen grid place-items-center">

    {{-- full-page-loader --}}
    <x-loaders.full-page-loader wire:loading/>

    <div class="flex flex-col items-center justify-center px-8 md:px-16 py-20">

        {{-- page title --}}
        <h1 class="font-bold text-3xl md:text-5xl text-violet-500 dark:text-white text-center">EVENTOS INSCRITOS</h1>
        {{-- person --}}
        <h3 class="font-medium text-xl md:text-2xl text-slate-300 text-left my-4">{{ $person->getFullName() }}</h3>
        {{-- register event attendance --}}
        <x-buttons.main-button wire:click="open_register_event_attendance_modal" color="teal" class="mt-3" textSize="md" class="px-3 rounded-sm">Inscribirme a un evento</x-buttons.main-button>

        {{-- events --}}
        <div class="flex flex-col gap-4 md:gap-8 mt-8">
            {{-- if count of events is greater than zero --}}
            {{--@if(count($events) > 0)--}}
            @if(count($attendances) > 0)
                {{-- loop of events, filtering by person_id --}}
                @foreach($attendances as $item)
                    <article class="m-auto bg-gray-100 dark:bg-slate-800 shadow-md border border-slate-900 hover:bg-gray-200 dark:hover:bg-slate-700 transition ease-in-out duration-300 w-full md:w-3/4 lg:w-1/2 rounded-md p-4 md:p-6">
                        {{-- head card info --}}
                        <header class="block w-full">
                            <div class="inline-flex w-full items-start gap-8">
                                <h3 class="flex-grow text-white text-lg md:text-xl font-bold break-words">{{ $item->event->name }}</h3>
                                <time class="text-slate-300 text-lg md:text-xl font-medium italic justify-self-end">{{ $item->event->year }}</time>
                            </div>
                            <h3 class="font-normal text-md md:text-lg text-amber-200 text-left mt-1">{{ __($item->get_participation_modality('key_name')) }}</h3>
                        </header>
                        {{-- info --}}
                        <div class="flex flex-col items-start w-full mt-4">
                        </div>
                        {{-- additional info --}}
                        <footer class="flex flex-col md:flex-row items-start w-full mt-8 select-none">
                            {{-- activities of event --}}
                            <h3 class="text-slate-100 text-sm md:text-md font-normal md:flex-grow">Actividades: <b>{{ $item->event->activities->count() }}</b></h3>
                            {{-- activity attendance info --}}
                            <div class="flex flex-row space-x-2">
                                <span class="text-blue-300 text-sm md:text-md font-normal md:flex-grow">Inscritas: <b>{{ $item->get_activities_by_state(data: false) }}</b></span>
                                <span class="text-green-300 text-sm md:text-md font-normal md:flex-grow">Realizadas: <b>{{ $person->get_total_activities_attendance($item->event_id) }}</b></span>
                                <span class="text-red-300 text-sm md:text-md font-normal md:flex-grow">Sin realizar: <b>{{ $item->get_activities_by_state('DO', false) }}</b></span>
                                {{--<span class="text-red-300 text-sm font-normal md:flex-grow">Sin realizar: {{ $person->activity_attendances()->join('activities as a', 'activity_attendances.activity_id', '=', 'a.id')->where('a.event_id', $item->event_id)->where('a.hide', 0)->where('activity_attendances.state', '<>', 'DO')->select('activity_attendances.id')->count() }}</span>--}}
                            </div>
                        </footer>
                        {{-- actions --}}
                        @if($item->event->state != 'CP')
                            <div class="flex flex-row space-x-2 w-full justify-end mt-6">
                                {{-- virtual_card --}}
                                <x-buttons.main-button wire:click="open_virtual_card({{ $item->event }})" color="violet" class="px-3 rounded-sm">Carnet Virtual</x-buttons.main-button>
                                {{-- open event --}}
                                <x-buttons.main-button wire:click="open_activities({{ $item->event }})" color="sky" class="px-3 rounded-sm">Actividades</x-buttons.main-button>
                            </div>
                        @else
                            <div class="flex flex-row space-x-2 w-full justify-end mt-6">
                                @if($item->can_get_certificate())
                                    {{-- certificate button --}}
                                    <x-buttons.main-button wire:click="generate_certificate({{ $item }})" color="indigo" class="px-3 rounded-sm">Certificado</x-buttons.main-button>
                                @else
                                    <span class="font-normal text-sm text-red-400 italic">No puedes acceder al certificado porque no cumples con los requisitos minímos</span>
                                @endif
                            </div>
                        @endif
                    </article>
                @endforeach
            {{-- else, then show custom info message --}}
            @else
                <p class="font-normal text-lg md:text-xl text-red-700 dark:text-red-400 text-left mt-4">No tienes eventos inscritos, por favor realiza la inscripción o comunícate con los organizadores del evento para mayor información.</p>
            @endif
        </div>
    </div>

    {{-- components --}}

    {{-- register-event-attendance --}}
    <livewire:portal.register-event-attendance/>

</div>
