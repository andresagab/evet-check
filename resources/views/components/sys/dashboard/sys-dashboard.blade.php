{{-- php code --}}
@php
    use \App\Models\Sys\Activity;
    use \App\Models\Sys\Event;
    use \App\Models\Sys\Person;
@endphp

{{-- template --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 w-full">

    {{-- events info --}}
    <article class="bg-slate-800/60 backdrop-blur-sm p-6 rounded-2xl ring-1 ring-slate-700 shadow-lg">
        <header class="flex items-center gap-4">
            <div class="bg-indigo-500/10 text-indigo-400 p-3 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div class="flex-1">
                <a wire:navigate.hover href="{{ route('sys.events') }}" title="Ir a eventos" class="hover:underline">
                    <h3 class="text-2xl font-bold text-white">{{ __('messages.menu.events') }}</h3>
                </a>
                <p class="text-sm text-slate-400">Total registrados: <span class="font-semibold text-indigo-300">{{ Event::query()->count('id') }}</span></p>
            </div>
        </header>

        <footer class="mt-6 space-y-3">
            <div class="flex justify-between items-center text-lg">
                <span class="text-blue-300">Abiertos:</span>
                <span class="text-blue-400 font-bold">{{ Event::query()->where('state', 'OP')->count('id') }}</span>
            </div>
            <div class="flex justify-between items-center text-lg">
                <span class="text-yellow-300">En curso:</span>
                <span class="text-yellow-400 font-bold">{{ Event::query()->where('state', 'OG')->count('id') }}</span>
            </div>
            <div class="flex justify-between items-center text-lg">
                <span class="text-green-300">Terminados:</span>
                <span class="text-green-400 font-bold">{{ Event::query()->where('state', 'CP')->count('id') }}</span>
            </div>
        </footer>
    </article>

    {{-- activities info --}}
    <article class="bg-slate-800/60 backdrop-blur-sm p-6 rounded-2xl ring-1 ring-slate-700 shadow-lg">
        <header class="flex items-center gap-4">
            <div class="bg-rose-500/10 text-rose-400 p-3 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <div class="flex-1">
                <a wire:navigate.hover href="{{ route('sys.activities') }}" title="Ir a actividades" class="hover:underline">
                    <h3 class="text-2xl font-bold text-white">{{ __('messages.menu.activities') }}</h3>
                </a>
                <p class="text-sm text-slate-400">Total registradas: <span class="font-semibold text-rose-300">{{ Activity::query()->count('id') }}</span></p>
            </div>
        </header>

        <footer class="grid grid-cols-2 gap-6 mt-6">
            <div class="flex flex-col space-y-2">
                <h3 class="font-semibold text-lg text-slate-300 border-b border-slate-700 pb-1 mb-1">Resumen</h3>
                <div class="flex justify-between items-center text-md">
                    <span class="text-blue-300">Abiertas:</span>
                    <span class="text-blue-400 font-semibold">{{ Activity::query()->where('status', 'O')->count('id') }}</span>
                </div>
                <div class="flex justify-between items-center text-md">
                    <span class="text-yellow-300">En curso:</span>
                    <span class="text-yellow-400 font-semibold">{{ Activity::query()->where('status', 'I')->count('id') }}</span>
                </div>
                <div class="flex justify-between items-center text-md">
                    <span class="text-green-300">Terminadas:</span>
                    <span class="text-green-400 font-semibold">{{ Activity::query()->where('status', 'C')->count('id') }}</span>
                </div>
            </div>
            <div class="flex flex-col space-y-2">
                <h3 class="font-semibold text-lg text-slate-300 border-b border-slate-700 pb-1 mb-1">Tipos</h3>
                @foreach(Activity::get_types() as $key => $type)
                    <div class="flex justify-between items-center text-md">
                        <span class="text-slate-300">{{ $type }}:</span>
                        <span class="text-slate-400 font-semibold">{{ Activity::query()->where('type', $key)->count('id') }}</span>
                    </div>
                @endforeach
            </div>
        </footer>
    </article>

    {{-- people info --}}
    <article class="bg-slate-800/60 backdrop-blur-sm p-6 rounded-2xl ring-1 ring-slate-700 shadow-lg">
        <header class="flex items-center gap-4">
            <div class="bg-cyan-500/10 text-cyan-400 p-3 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </div>
            <div class="flex-1">
                <a wire:navigate.hover href="{{ route('sys.people') }}" title="Ir a personas" class="hover:underline">
                    <h3 class="text-2xl font-bold text-white">{{ __('messages.menu.people') }}</h3>
                </a>
                <p class="text-sm text-slate-400">Total registradas: <span class="font-semibold text-cyan-300">{{ Person::query()->count('id') }}</span></p>
            </div>
        </header>

        <footer class="mt-6 space-y-2">
            @php
                $attendance_info = Person::query()->join('activity_attendances as aa', 'people.id', '=', 'aa.person_id')->selectRaw('aa.state, count(aa.id) as count')->groupBy('aa.state')->pluck('count', 'state')->toArray();
                $signed_up = $attendance_info['SU'] ?? 0;
                $done = $attendance_info['DO'] ?? 0;
                $unrealized = ($attendance_info['UR'] ?? 0);
                $total_in_activities = $signed_up + $done + $unrealized;
            @endphp

            <div class="flex justify-between items-center text-md">
                <span class="text-blue-300">Registradas en eventos:</span>
                <span class="text-blue-400 font-semibold">{{ Person::query()->join('event_attendances as ea', 'people.id', '=', 'ea.person_id')->distinct('people.id')->count('people.id') }}</span>
            </div>
            <div class="flex justify-between items-center text-md">
                <span class="text-purple-300">Registradas en actividades:</span>
                <span class="text-purple-400 font-semibold">{{ $total_in_activities }}</span>
            </div>

            <hr class="border-slate-700 my-3">

            <div class="flex justify-between items-center text-md">
                <span class="text-sky-300">Inscritas en actividades:</span>
                <span class="text-sky-400 font-semibold">{{ $signed_up }}</span>
            </div>
            <div class="flex justify-between items-center text-md">
                <span class="text-green-300">Realizaron las actividades:</span>
                <span class="text-green-400 font-semibold">{{ $done }}</span>
            </div>
            <div class="flex justify-between items-center text-md">
                <span class="text-red-300">No realizaron las actividades:</span>
                <span class="text-red-400 font-semibold">{{ $unrealized }}</span>
            </div>
        </footer>
    </article>

</div>
