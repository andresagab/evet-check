<div>

    {{-- full-page-loader --}}
    <x-loaders.full-page-loader wire:loading/>

    {{-- main layer --}}
    <div class="w-full flex flex-col p-8 md:p-16">

        {{-- page name --}}
        <h1 class="font-bold text-3xl md:text-5xl text-white text-center mt-10 md:mt-6">INSCRIPCIÓN DE ACTIVIDADES</h1>

        {{-- event --}}
        <h2 class="font-normal text-xl md:text-3xl text-sky-100 text-center mt-8">{{ $event->name }}</h2>
        {{-- person --}}
        <h3 class="font-medium text-lg md:text-xl text-slate-100 text-left mt-4">{{ $person->getFullName() }}</h3>
        <h4 class="font-normal text-sm md:text-md text-slate-300 italic text-left mt-1">{{ $person->event_attendances()->where('event_id', $event->id)->first()->get_type() }}</h4>

        {{-- instructions --}}
        <p class="font-thin text-md md:text-lg text-slate-200 text-justify mt-4">A continuación, se presentan las actividades que se realizarán durante el evento, estas están ordenadas y agrupadas por <b>día</b> y <b>hora</b>. Recuerda que solo puedes inscribir una actividad por bloque horario; en consecuencia, no podrás inscribir 2 o más actividades que se realicen en la misma hora del mismo día.</p>

        {{-- loop of dates --}}
        @foreach($activities_dates as $activity_date)
            <div class="flex flex-col mt-7 md:mt-14">

                {{-- date --}}
                <h3 class="text-white font-bold text-xl md:text-2xl border-t border-slate-100 pt-4">{{ \Illuminate\Support\Carbon::createFromTimeString("$activity_date 00:00:00")->format('d F Y') }}</h3>

                {{-- hours of date --}}
                <div class="flex flex-col mt-4 md:mt-6 p-4 md:p-8">
                    {{-- hours --}}
                    @foreach($activities_hours as $hour)

                        {{-- php code --}}
                        @php

                            # define date
                            $date_start = \Illuminate\Support\Carbon::createFromTimeString("$activity_date 00:00:00");
                            $date_end = \Illuminate\Support\Carbon::createFromTimeString("$activity_date 23:59:59");
                            # define date_hour
                            $date_hour = \Illuminate\Support\Carbon::createFromTimeString($hour);

                        @endphp

                        {{-- if date_hour between date_start and date_end --}}
                        @if($date_hour->between($date_start, $date_end))

                            <div class="flex flex-col mb-4 md:mb-6 border-t border-dashed border-slate-300 pt-4">
                                {{-- hour --}}
                                <h3 class="text-slate-200 font-semibold text-lg md:text-xl">{{ $date_hour->format('h:i A') }}</h3>

                                {{-- grid of activities --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-4 p-2">

                                    {{-- loop to show each activity --}}
                                    @foreach($activities as $item)

                                        {{-- php code --}}
                                        @php

                                        # define activity date
                                        $ad = \Illuminate\Support\Carbon::createFromTimeString($item->date);

                                        @endphp

                                        {{-- if activity date is equal to date hour --}}
                                        @if($ad->equalTo($date_hour))

                                            {{-- php code --}}
                                            @php
                                                # define can_register_activity
                                                $can_register_activity = $person->can_register_activity($item);
                                            @endphp

                                            <div class="bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 shadow-md border border-slate-900 transition ease-in-out duration-300 w-full h-full rounded-md p-4">
                                                {{-- info --}}
                                                <article class="flex flex-col items-start w-full h-full">
                                                    {{-- type and hour --}}
                                                    <header class="flex flex-row items-center w-full">
                                                        <h3 class="text-slate-300 text-sm font-normal flex-grow">{{ $item->get_type() }}</h3>
                                                        <h3 class="text-slate-300 text-sm font-thin flex-shrink">{{ $date_hour->format("d M Y h:i a") }}</h3>
                                                    </header>
                                                    {{-- name, author, modality --}}
                                                    <div class="flex flex-col items-start w-full mt-6">
                                                        <h3 class="text-white text-xl lg:text-2xl font-bold break-words">{{ $item->name }}</h3>
                                                        <h3 class="text-slate-100 text-md lg:text-lg font-normal">{{ $item->author_name }}</h3>
                                                        <h3 class="text-slate-300 text-sm lg:text-md font-thin">{{ $item->get_modality() }}</h3>
                                                    </div>

                                                    {{-- location info --}}
                                                    @if($item->location)
                                                        <div
                                                            class="flex items-center justify-center space-x-2 mt-12 w-full"
                                                            title="Ubicación de la actividad"
                                                        >
                                                            <div class="flex flex-col grow items-start justify-start">
                                                                <h3 class="text-slate-50 text-sm font-medium">Lugar:</h3>
                                                                <h3 class="text-slate-100 text-sm font-normal md:flex-grow break-words">{{ $item->location->name }}</h3>
                                                                @if($item->location->address)
                                                                    @if($item->location->url)
                                                                        <a
                                                                            href="{{ $item->location->url }}"
                                                                            target="_blank"
                                                                            title="Ver ubicación en el mapa"
                                                                            class="text-slate-300 text-sm font-normal italic underline">{{ $item->location->address }}</a>
                                                                    @else
                                                                        <h4 class="text-slate-300 text-sm font-normal italic">{{ $item->location->address }}</h4>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                            {{--<x-utils.icon class="dark:text-sky-400 select-none">place</x-utils.icon>--}}
                                                        </div>
                                                    @endif

                                                    {{-- additional info --}}
                                                    <div class="flex flex-col grow items-start w-full h-full select-none mt-4">

                                                        <h3 class="text-slate-300 text-md font-normal md:flex-grow">
                                                            Estado:
                                                            <span class="font-medium text-{{ $item->get_status_color() }}-400">{{ $item->get_status() }}</span>
                                                        </h3>
                                                        {{-- if can_register_activity is true --}}
                                                        @if($item->get_free_slots() === 0)
                                                            <span class="text-md font-normal italic dark:text-red-300">Está actividad no tiene cupos disponibles</span>
                                                        @else
                                                            <h3 class="text-slate-100 text-md font-thin" title="Cupos libres: {{ $item->get_free_slots() }} | Cupos habilitados: {{ $item->slots }}">Cupos: <span class="font-normal">{{ $item->activity_attendances()->count() }}/{{ $item->slots }}</span></h3>
                                                        @endif
                                                    </div>
                                                    {{-- actions --}}
                                                    <div class="flex flex-row w-full justify-end mt-10">
                                                        {{-- if can_register_activity is true --}}
                                                        @if($can_register_activity)
                                                            <x-buttons.main-button
                                                                wire:click="register_activity({{ $item }})"
                                                                wire:confirm="¿Estás seguro de inscribir la actividad: {{ $item->name }}?"
                                                                color="green"
                                                                class="px-3 py-1 rounded-sm font-semibold"
                                                            >Inscribirme
                                                            </x-buttons.main-button>
                                                        @elseif($item->activity_attendances()->where('person_id', $person->id)->count() === 1)
                                                            <span class="font-bold text-sm md:text-md text-yellow-500 select-none">Inscrito</span>
                                                        @endif
                                                    </div>
                                                </article>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>
                            </div>

                        @endif

                    @endforeach
                </div>

            </div>
        @endforeach



    </div>

</div>
