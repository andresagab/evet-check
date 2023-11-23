<div class="w-full h-screen grid place-items-center">

    {{-- full-page-loader --}}
    <x-loaders.full-page-loader wire:loading/>

    <div class="flex flex-col items-center justify-center">

        {{-- page title --}}
        <h3 class="text-2xl text-violet-500 dark:text-violet-300 font-bold">EVENTOS INSCRITOS</h3>
        {{-- person --}}
        <h3 class="text-white font-thin text-lg">Bienvenid{{ $person->sex == 'F' ? 'a' : 'o' }} {{ $person->getFullName() }}</h3>

        {{-- events --}}
        <div class="flex flex-col space-y-2 mt-8">
            {{-- loop of events, filtering by person_id --}}
            @foreach(\App\Models\Sys\Event::query()->join('event_attendances as ea', 'events.id', '=', 'ea.event_id')->where('ea.person_id', $person->id)->select('events.*')->orderBy('year')->get() as $item)
                <div class="m-auto bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 transition ease-in-out duration-300 w-1/2 rounded-md p-4">
                    {{-- info --}}
                    <div class="flex flex-col items-start space-y-1">
                        <h3 class="text-white text-xl font-bold flex-grow">{{ $item->name }}</h3>
                        <h3 class="text-slate-100 text-md font-normal">{{ $item->year }}</h3>
                        <h3 class="text-slate-300 text-sm font-normal">Actividades: {{ $item->activities->count() }}</h3>
                    </div>
                    {{-- actions --}}
                    <div class="flex flex-row w-full justify-end mt-4">
                        <x-buttons.secondary-button wire:click="open_activities({{ $item }})" color="sky">Abrir</x-buttons.secondary-button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
