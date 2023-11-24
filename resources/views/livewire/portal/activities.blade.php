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
        <h3 class="font-thin text-lg md:text-xl text-slate-100 text-left mt-4">{{ $person->getFullName() }}</h3>

        {{-- instructions --}}
        <p class="font-thin text-md md:text-lg text-slate-200 text-justify mt-4">A continuación, se presentan las actividades que se realizarán durante el evento, estas están ordenadas y agrupadas por <b>día</b> y <b>hora</b>. Recuerda que solo puedes inscribir una actividad por bloque horario; en consecuencia, no podrás inscribir 2 o más actividades que se realicen en la misma hora del mismo día.</p>

        {{-- loop of dates --}}
        @foreach($activities_dates as $activity_date)
            <div class="flex flex-col mt-7 md:mt-14">

                {{-- date --}}
                <h3 class="text-white font-bold text-xl md:text-2xl">{{ \Illuminate\Support\Carbon::createFromTimeString("$activity_date 00:00:00")->format('d F Y') }}</h3>

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

                            <div class="flex flex-col mb-4 md:mb-6">
                                {{-- hour --}}
                                <h3 class="text-slate-200 font-semibold text-lg md:text-xl">{{ $date_hour->format('h:i A') }}</h3>

                                {{-- grid of activities --}}
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mt-4 p-2">

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

                                            <div class="m-auto bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 transition ease-in-out duration-300 w-full rounded-md p-4">
                                                {{-- info --}}
                                                <div class="flex flex-col items-start">
                                                    {{-- type and hour --}}
                                                    <div class="flex flex-row items-center w-full">
                                                        <h3 class="text-slate-300 text-sm font-normal flex-grow">{{ $item->get_type() }}</h3>
                                                        <h3 class="text-slate-300 text-sm font-thin flex-shrink">{{ $date_hour->format("h:i a") }}</h3>
                                                    </div>
                                                    {{-- name, author, modality --}}
                                                    <div class="flex flex-col items-start w-full mt-4">
                                                        <h3 class="text-white text-xl font-bold break-all">{{ $item->name }}</h3>
                                                        <h3 class="text-slate-100 text-md font-normal">{{ $item->author_name }}</h3>
                                                        <h3 class="text-slate-300 text-sm font-thin">{{ $item->get_modality() }}</h3>
                                                    </div>
                                                    {{-- additional info --}}
                                                    <div class="flex flex-col md:flex-row items-start w-full mt-4 select-none">
                                                        <h3 class="text-slate-300 text-sm font-normal md:flex-grow">Estado: {{ $item->get_status() }}</h3>
                                                        {{-- if can_register_activity is true --}}
                                                        @if($can_register_activity)
                                                            <h3 class="text-slate-100 text-sm font-thin">Cupos: <span class="font-normal">{{ $item->get_free_slots() }}/{{ $item->slots }}</span></h3>
                                                        @endif
                                                    </div>
                                                </div>
                                                {{-- actions --}}
                                                <div class="flex flex-row w-full justify-end mt-4">
                                                    {{-- if can_register_activity is true --}}
                                                    @if($can_register_activity)
                                                        <x-buttons.secondary-button wire:click="register_activity({{ $item }})" wire:confirm="¿Estás seguro de inscribir la actividad: {{ $item->name }}?" color="green">Inscribirme</x-buttons.secondary-button>
                                                    @elseif($item->activity_attendances()->where('person_id', $person->id)->count() === 1)
                                                        <span class="font-bold text-sm md:text-md text-yellow-500 select-none">Inscrito</span>
                                                    @endif
                                                </div>
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
