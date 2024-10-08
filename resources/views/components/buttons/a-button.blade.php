{{-- define props of component --}}
@props([
    'color' => 'green',
    'defaultPadding' => true,
    'defaultRounded' => true,
    'textSize'
])

@php
    # define default value of padding and rounded attributes
    $defaultPadding = $defaultPadding ? 'px-3 py-2' : null;
    $defaultRounded = $defaultRounded ? 'rounded-sm' : null;
    # set text size
    $textSize = \App\Utils\CommonUtils::TEXT_SIZE[$textSize ?? 'sm']
@endphp

<a {{ $attributes->merge(['class' => "middle none center $defaultRounded text-$color-900 bg-none hover:bg-$color-500 dark:text-$color-200 dark:bg-$color-800 dark:hover:bg-$color-900 hover:text-$color-50 $defaultPadding font-sans $textSize transition-all hover:shadow-lg hover:shadow-$color-500/40 dark:hover:shadow-$color-700/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none duration-300"]) }}>
    {{ $slot }}
</a>
