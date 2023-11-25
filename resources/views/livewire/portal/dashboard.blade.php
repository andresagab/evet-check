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
            {{-- loop of events, filtering by person_id --}}
            @foreach(\App\Models\Sys\Event::query()->join('event_attendances as ea', 'events.id', '=', 'ea.event_id')->where('ea.person_id', $person->id)->select('events.*')->orderBy('year', 'DESC')->get() as $item)
                <div class="m-auto bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 transition ease-in-out duration-300 w-full md:w-1/2 rounded-md p-4">
                    {{-- head card info --}}
                    <div class="flex flex-row items-center w-full">
                        <h3 class="text-slate-300 text-sm font-normal flex-grow">{{ $item->year }}</h3>
                    </div>
                    {{-- info --}}
                    <div class="flex flex-col items-start w-full mt-4">
                        <h3 class="text-white text-xl font-bold flex-grow">{{ $item->name }}</h3>
                    </div>
                    {{-- additional info --}}
                    <div class="flex flex-col md:flex-row items-start w-full mt-5 select-none">
                        <h3 class="text-slate-300 text-sm font-normal md:flex-grow">Actividades: {{ $item->activities->count() }}</h3>
                    </div>
                    {{-- actions --}}
                    @if($item->state != 'CP')
                        <div class="flex flex-row space-x-2 w-full justify-end mt-4">
                            {{-- virtual_card --}}
                            <x-buttons.secondary-button wire:click="open_virtual_card({{ $item }})" color="violet">Carnet Virtual</x-buttons.secondary-button>
                            {{-- open event --}}
                            <x-buttons.secondary-button wire:click="open_activities({{ $item }})" color="sky">Actividades</x-buttons.secondary-button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

</div>
