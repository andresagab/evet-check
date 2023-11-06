{{-- props of component --}}
@props([
    'title',
    'color' => 'white',
    'footer' => true,
])

{{-- template --}}
<div class="w-full bg-{{ $color }} rounded-md shadow-md shadow-zin-500/60 hover:shadow-lg px-4 py-6 transition-all ease-in-out duration-300">
    {{-- card title --}}
    <h3 class="font-semibold text-emerald-800 text-md">{{ $title }}</h3>
    {{-- card content --}}
    <div class="mt-6">
        {{ $content }}
    </div>
    {{-- card footer --}}
    @if($footer)
        <div class="flex flex-row items-center space-x-2 mt-6">
            {{-- main --}}
            <div class="flex-grow">
                {{ $main_footer }}
            </div>
            {{-- secondary --}}
            <div class="flex-shrink">
                {{ $secondary_footer }}
            </div>
        </div>
    @endif
</div>
