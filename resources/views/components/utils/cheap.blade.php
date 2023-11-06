{{-- props of component --}}
@props([
    'color' => 'gray'
])

{{-- template --}}
<span {{ $attributes->merge(['class' => "px-2 py-0.5 bg-$color-300 text-$color-950 rounded-full hover:shadow transition ease-in-out duration-300"]) }}>{{ $slot }}</span>
