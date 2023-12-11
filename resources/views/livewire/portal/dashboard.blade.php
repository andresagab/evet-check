<div class="w-full h-screen grid place-items-center">

    {{-- full-page-loader --}}
    <x-loaders.full-page-loader wire:loading/>

    <div class="flex flex-col items-center justify-center p-8 md:p-16">

        {{-- page title --}}
        <h1 class="font-bold text-3xl md:text-5xl text-violet-500 dark:text-white text-center">EVENTOS INSCRITOS</h1>
        {{-- person --}}
        <h3 class="font-normal text-lg md:text-xl text-slate-100 text-left mt-4">{{ $person->getFullName() }}</h3>

        {{-- events --}}
        <div class="flex flex-col space-y-2 mt-8">
            {{-- if count of events is greater than zero --}}
            {{--@if(count($events) > 0)--}}
            @if(count($attendances) > 0)
                {{-- loop of events, filtering by person_id --}}
                {{--@foreach($events as $item)--}}
                @foreach($attendances as $item)
                    <div class="m-auto bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 transition ease-in-out duration-300 w-full md:w-1/2 rounded-md p-4">
                        {{-- head card info --}}
                        <div class="flex flex-row items-center w-full">
                            <h3 class="text-slate-300 text-sm font-normal flex-grow">{{ $item->event->year }}</h3>
                            <h3 class="font-thin text-sm text-slate-300 text-left mt-2">{{ __($item->get_participation_modality('key_name')) }}</h3>
                        </div>
                        {{-- info --}}
                        <div class="flex flex-col items-start w-full mt-4">
                            <h3 class="text-white text-xl font-bold flex-grow">{{ $item->event->name }}</h3>
                        </div>
                        {{-- additional info --}}
                        <div class="flex flex-col md:flex-row items-start w-full mt-8 select-none">
                            {{-- activities of event --}}
                            <h3 class="text-slate-300 text-sm font-normal md:flex-grow">Actividades: {{ $item->event->activities->count() }}</h3>
                            {{-- activity attendance info --}}
                            <div class="flex flex-row space-x-2">
                                <span class="text-blue-300 text-sm font-normal md:flex-grow">Inscritas: {{ $item->get_activities_by_state(data: false) }}</span>
                                <span class="text-green-300 text-sm font-normal md:flex-grow">Realizadas: {{ $person->get_total_activities_attendance($item->event_id) }}</span>
                                <span class="text-red-300 text-sm font-normal md:flex-grow">Sin realizar: {{ $item->get_activities_by_state('DO', false) }}</span>
                                {{--<span class="text-red-300 text-sm font-normal md:flex-grow">Sin realizar: {{ $person->activity_attendances()->join('activities as a', 'activity_attendances.activity_id', '=', 'a.id')->where('a.event_id', $item->event_id)->where('a.hide', 0)->where('activity_attendances.state', '<>', 'DO')->select('activity_attendances.id')->count() }}</span>--}}
                            </div>
                        </div>
                        {{-- actions --}}
                        @if($item->event->state != 'CP')
                            <div class="flex flex-row space-x-2 w-full justify-end mt-6">
                                {{-- virtual_card --}}
                                <x-buttons.secondary-button wire:click="open_virtual_card({{ $item->event }})" color="violet">Carnet Virtual</x-buttons.secondary-button>
                                {{-- open event --}}
                                <x-buttons.secondary-button wire:click="open_activities({{ $item->event }})" color="sky">Actividades</x-buttons.secondary-button>
                            </div>
                        @else
                            <div class="flex flex-row space-x-2 w-full justify-end mt-6">
                                @if($item->can_get_certificate())
                                    {{-- certificate button --}}
                                    <x-buttons.secondary-button wire:click="generate_certificate({{ $item }})" color="violet">Certificado</x-buttons.secondary-button>
                                @else
                                    <span class="font-normal text-sm text-red-400 italic">No puedes acceder al certificado porque no cumples con los requisitos minímos</span>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            {{-- else, then show custom info message --}}
            @else
                <p class="font-normal text-lg md:text-xl text-red-700 dark:text-red-400 text-left mt-4">No tienes eventos inscritos, por favor comunicate con los organizadores del evento para realizar tu inscripción.</p>
            @endif
        </div>
    </div>

</div>
