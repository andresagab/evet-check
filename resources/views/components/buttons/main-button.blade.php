{{-- define props of component --}}
@props([
    'color' => 'green',
    'defaultPadding' => true,
    'defaultRounded' => true,
    'textSize'
])

@php
    # define default value of padding and rounded attributes
    $defaultPadding = $defaultPadding ? 'px-3 py-1' : null;
    $defaultRounded = $defaultRounded ? 'rounded-lg' : null;
    # set text size
    $textSize = \App\Utils\CommonUtils::TEXT_SIZE[$textSize ?? 'sm']
@endphp

<button {{ $attributes->merge(['class' => "middle none center $defaultRounded bg-$color-500 hover:bg-$color-700 hover:text-$color-50 $defaultPadding font-sans $textSize text-white shadow-md shadow-$color-500/20 transition-all hover:shadow-lg hover:shadow-$color-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none duration-300", 'type' => 'button']) }}>
    {{ $slot }}
</button>
