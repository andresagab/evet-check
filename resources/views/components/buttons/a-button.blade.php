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
    $textSize = [
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'md' => 'text-md',
        'lg' => 'text-lg',
        'xl' => 'text-xl',
        '2xl' => 'text-2xl',
    ][$textSize ?? 'sm']
@endphp

<a {{ $attributes }} {{ $attributes->merge(['class' => "middle none center $defaultRounded text-$color-900 bg-none hover:bg-$color-500 hover:text-$color-50 $defaultPadding font-sans $textSize transition-all hover:shadow-lg hover:shadow-$color-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none duration-300", 'type' => 'button']) }}>
    {{ $slot }}
</a>
