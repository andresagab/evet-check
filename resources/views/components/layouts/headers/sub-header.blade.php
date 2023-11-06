{{-- props of component --}}
@props([
    'title',
    'color' => 'amber',
    'actions' => false,
])

{{-- template --}}
<div class="bg-{{ $color }}-300 shadow-md px-4 py-2 w-full hover:shadow-{{ $color }}-500/60 transition-all ease-in-out duration-300">
    <div class="flex flex-row space-x-2 items-center align-middle">
        {{-- page title --}}
        <span class="flex-grow select-none font-semibold text-md text-amber-800">{{ $title }}</span>
        {{-- actions --}}
        @if($actions)
            <div class="flex-shrink flex flex-row items-center justify-center align-middle space-x-2">
                {{ $slot }}
            </div>
        @endif
    </div>
</div>
