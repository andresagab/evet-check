{{-- props of component --}}
@props(['created_at', 'updated_at' => null, 'extra_dates' => null])

{{-- template --}}
<div class="flex flex-col">
    {{-- created_at --}}
    <div class="inline-flex items-center space-x-2" title="{{ __('messages.data.created_at') }}">
        <x-utils.icon class="text-green-600" size="16px">calendar_month</x-utils.icon>
        <span class="font-normal">{{ \Illuminate\Support\Carbon::createFromTimeString($created_at)->format('Y-m-d h:i a') }}</span>
    </div>
    {{-- updated_at --}}
    @if($updated_at)
        <div class="inline-flex items-center space-x-2" title="{{ __('messages.data.updated_at') }}">
            <x-utils.icon class="text-violet-600" size="16px">edit_calendar</x-utils.icon>
            <span class="font-normal">{{ \Illuminate\Support\Carbon::createFromTimeString($updated_at)->format('Y-m-d h:i a') }}</span>
        </div>
    @endif
    {{-- extra_dates --}}
    {{ $extra_dates }}
</div>
