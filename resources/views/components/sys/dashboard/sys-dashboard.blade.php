{{-- php code --}}
@php
    use \App\Models\Sys\Activity;
    use \App\Models\Sys\Event;
    use \App\Models\Sys\Person;
@endphp

{{-- template --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 w-full">

    {{-- events info --}}
    <article class="bg-slate-800 shadow-md p-4 rounded-md">
        <header class="text-lg md:text-xl lg:text-3xl text-white">
            <a wire:navigate.hover href="{{ route('sys.events') }}" title="Ir a eventos" class="hover:underline">
                <h3 class="font-semibold">{{ __('messages.menu.events') }}</h3>
            </a>
        </header>
        <footer class="block mt-8">
            <div class="flex flex-col">
                <div class="text-md md:text-lg lg:text-xl">
                    <span class="text-indigo-300">Registrados:</span>
                    <span class="text-indigo-400 font-semibold">{{ Event::query()->count('id') }}</span>
                </div>
                <div class="text-md md:text-lg lg:text-xl">
                    <span class="text-blue-300">Abiertos:</span>
                    <span class="text-blue-400 font-semibold">{{ Event::query()->where('state', 'OP')->count('id') }}</span>
                </div>
                <div class="text-md md:text-lg lg:text-xl">
                    <span class="text-yellow-300">En curso:</span>
                    <span class="text-yellow-400 font-semibold">{{ Event::query()->where('state', 'OG')->count('id') }}</span>
                </div>
                <div class="text-md md:text-lg lg:text-xl">
                    <span class="text-green-300">Terminados:</span>
                    <span class="text-green-400 font-semibold">{{ Event::query()->where('state', 'CP')->count('id') }}</span>
                </div>
            </div>
        </footer>
    </article>

    {{-- activities info --}}
    <article class="bg-slate-800 shadow-md p-4 rounded-md">
        <header class="text-lg md:text-xl lg:text-3xl text-white">
            <a wire:navigate.hover href="{{ route('sys.activities') }}" title="Ir a actividades" class="hover:underline">
                <h3 class="font-semibold">{{ __('messages.menu.activities') }}</h3>
            </a>
        </header>
        <footer class="grid grid-cols-2 gap-8 mt-8">
            <div class="flex flex-col">
                <h3 class="font-medium text-md md:text-lg lg:text-xl text-slate-300">Resumen:</h3>
                <hr class="mb-4">
                <div class="text-md md:text-lg lg:text-xl">
                    <span class="text-indigo-300">Registrados:</span>
                    <span class="text-indigo-400 font-semibold">{{ Activity::query()->count('id') }}</span>
                </div>
                <div class="text-md md:text-lg lg:text-xl">
                    <span class="text-blue-300">Abiertos:</span>
                    <span class="text-blue-400 font-semibold">{{ Activity::query()->where('status', 'O')->count('id') }}</span>
                </div>
                <div class="text-md md:text-lg lg:text-xl">
                    <span class="text-yellow-300">En curso:</span>
                    <span class="text-yellow-400 font-semibold">{{ Activity::query()->where('status', 'I')->count('id') }}</span>
                </div>
                <div class="text-md md:text-lg lg:text-xl">
                    <span class="text-green-300">Terminados:</span>
                    <span class="text-green-400 font-semibold">{{ Activity::query()->where('status', 'C')->count('id') }}</span>
                </div>
            </div>
            <div class="flex flex-col">
                <h3 class="font-medium text-md md:text-lg lg:text-xl text-slate-300">Tipos:</h3>
                <hr class="mb-4">
                @foreach(Activity::get_types() as $key => $type)
                    <div class="text-md md:text-lg lg:text-xl">
                        <span class="text-rose-300">{{ $type }}:</span>
                        <span class="text-rose-400 font-semibold">{{ Activity::query()->where('type', $key)->count('id') }}</span>
                    </div>
                @endforeach
            </div>
        </footer>
    </article>

    {{-- people info --}}
    <article class="bg-slate-800 shadow-md p-4 rounded-md">
        <header class="text-lg md:text-xl lg:text-3xl text-white">
            <a wire:navigate.hover href="{{ route('sys.people') }}" title="Ir a personas" class="hover:underline">
                <h3 class="font-semibold">{{ __('messages.menu.people') }}</h3>
            </a>
        </header>
        <footer class="block mt-8">
            <div class="flex flex-col">

                @php
                $attendance_info = Person::query()->join('activity_attendances as aa', 'people.id', '=', 'aa.person_id')->selectRaw('aa.state, count(aa.id) as count')->groupBy('aa.state')->pluck('count', 'state')->toArray();
                $registered = $attendance_info['SU'] ?? 0;
                $done = $attendance_info['DO'] ?? 0;
                $unrealized = ($attendance_info['UR'] ?? 0) + $registered;
                $all_attendance = $registered + $done + ($attendance_info['UR'] ?? 0);
                @endphp

                <div class="text-md md:text-lg lg:text-xl">
                    <span class="text-indigo-300">Registradas:</span>
                    <span class="text-indigo-400 font-semibold">{{ Person::query()->count('id') }}</span>
                </div>
                <div class="text-md md:text-lg lg:text-xl">
                    <span class="text-blue-300">Registradas en eventos:</span>
                    <span class="text-blue-400 font-semibold">{{ Person::query()->join('event_attendances as ea', 'people.id', '=', 'ea.person_id')->count('people.id') }}</span>
                </div>
                <div class="text-md md:text-lg lg:text-xl">
                    <span class="text-purple-300">Registradas en actividades:</span>
                    <span class="text-purple-400 font-semibold">{{ $all_attendance }}</span>
                </div>
                <div class="text-md md:text-lg lg:text-xl">
                    <span class="text-sky-300">Inscritas en actividades:</span>
                    <span class="text-sky-400 font-semibold">{{ $registered }}</span>
                </div>
                <div class="text-md md:text-lg lg:text-xl">
                    <span class="text-green-300">Realizaron las actividades:</span>
                    <span class="text-green-400 font-semibold">{{ $done }}</span>
                </div>
                <div class="text-md md:text-lg lg:text-xl">
                    <span class="text-red-300">No realizaron las actividades:</span>
                    <span class="text-red-400 font-semibold">{{ $unrealized }}</span>
                </div>
            </div>
        </footer>
    </article>

</div>
