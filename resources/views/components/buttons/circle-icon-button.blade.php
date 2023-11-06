{{-- define props of component --}}
@props([
    'color' => 'green',
    'size' => '24px',
])

{{-- template --}}
<button {{ $attributes->merge(['class' => "flex items-center justify-center font-normal p-1 rounded-full border-none text-$color-500 bg-none hover:bg-$color-500 hover:text-white focus:bg-$color-600 focus:text-white transition duration-300 ease select-none", 'type' => 'button']) }}>
    <span class="material-icons" style="font-size: {{ $size }}">{{ $slot }}</span>
</button>
