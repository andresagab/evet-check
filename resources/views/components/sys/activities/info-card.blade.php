{{-- props of component --}}
@props([
    'activity',
    'bg_color' => 'gray-100',
    'bg_dark_color' => 'slate-800',
])

{{-- template --}}
<article class="m-auto bg-{{ $bg_color }} dark:bg-{{ $bg_dark_color }} hover:bg-gray-200 dark:hover:bg-slate-700 transition ease-in-out duration-300 w-full rounded-md p-4">
    {{-- info --}}
    <div class="flex flex-col items-start">
        {{-- type and hour --}}
        <div class="flex flex-row items-center w-full">
            <h3 class="text-slate-300 text-sm font-normal flex-grow">{{ $activity->get_type() }}</h3>
            <h3 class="text-slate-300 text-sm font-thin flex-shrink">{{ \Illuminate\Support\Carbon::createFromTimeString($activity->date)->format('d F Y h:i a') }}</h3>
        </div>
        {{-- name, author, modality --}}
        <div class="flex flex-col items-start w-full mt-4">
            <h3 class="text-white text-xl font-bold break-all">{{ $activity->name }}</h3>
            <h3 class="text-slate-100 text-md font-normal">{{ $activity->author_name }}</h3>
            <h3 class="text-slate-300 text-sm font-thin">{{ $activity->get_modality() }}</h3>
        </div>
        @if($activity->location)
            <div class="flex flex-col items-start justify-start mt-4">
                <h3 class="text-slate-100 text-sm font-normal md:flex-grow">{{ __('messages.models.activity.location') }}: {{ $activity->location->name }}</h3>
                @if($activity->location->address)
                    @if($activity->location->url)
                        <a
                            href="{{ $activity->location->url }}"
                            target="_blank"
                            title="Ver ubicación en el mapa"
                            class="text-slate-300 text-sm font-normal italic">{{ $activity->location->address }}</a>
                    @else
                        <h4 class="text-slate-300 text-sm font-normal italic">{{ $activity->location->address }}</h4>
                    @endif
                @endif
            </div>
        @endif
        {{-- additional info --}}
        <div class="flex flex-col md:flex-row md:space-x-2 items-start w-full mt-4 select-none">
            {{-- state --}}
            <h3 class="text-slate-300 text-sm font-normal md:flex-grow">{{ __('messages.models.activity.status') }}: {{ $activity->get_status() }}</h3>
            {{-- slots --}}
            <h3 class="text-slate-100 text-sm font-normal dark:text-purple-300">{{ __('messages.models.activity.slots') }}: <span class="font-normal">{{ $activity->slots }}</span></h3>
            {{-- signed slots --}}
            <h3 class="text-slate-100 text-sm font-normal dark:text-blue-300">Inscritos: <span class="font-normal">{{ $activity->activity_attendances()->count() }}</span></h3>
            {{-- done slots --}}
            <h3 class="text-slate-100 text-sm font-normal dark:text-green-300">Asistentes: <span class="font-normal">{{ $activity->activity_attendances()->where('state', 'DO')->count() }}</span></h3>
            {{-- unrealized slots --}}
            <h3 class="text-slate-100 text-sm font-normal dark:text-red-300">No asistieron: <span class="font-normal">{{ $activity->activity_attendances()->count() - $activity->activity_attendances()->where('state', 'DO')->count() }}</span></h3>
        </div>
    </div>
</article>
