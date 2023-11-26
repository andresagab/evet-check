{{-- props of component --}}
@props([
    'activity',
    'bg_color' => 'gray-100',
    'bg_dark_color' => 'slate-800',
])

{{-- template --}}
<div class="m-auto bg-{{ $bg_color }} dark:bg-{{ $bg_dark_color }} hover:bg-gray-200 dark:hover:bg-slate-700 transition ease-in-out duration-300 w-full rounded-md p-4">
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
        {{-- additional info --}}
        <div class="flex flex-col md:flex-row items-start w-full mt-4 select-none">
            {{-- state --}}
            <h3 class="text-slate-300 text-sm font-normal md:flex-grow">{{ __('messages.models.activity.status') }}: {{ $activity->get_status() }}</h3>
            {{-- slots --}}
            <h3 class="text-slate-100 text-sm font-thin">{{ __('messages.models.activity.slots') }}: <span class="font-normal">{{ $activity->activity_attendances()->count() }}/{{ $activity->slots }}</span></h3>
        </div>
    </div>
</div>
