{{-- define props of component --}}
@props([
    'value',
    'textSize',
    'color' => 'zinc',
    #'active_color' => 'blue',
])

@php

    # set text size
    $textSize = \App\Utils\CommonUtils::TEXT_SIZE[$textSize ?? 'sm']

@endphp

{{-- template --}}
<label
    {!!

    $attributes->merge([
        # 'class' => "absolute top-3 -z-10 origin-[0] -translate-y-6 scale-75 transform text-sm text-$color-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:left-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:text-$active_color-600 peer-focus:dark:text-$active_color-500"
        'class' => "font-semibold $textSize text-$color-900 dark:text-stone-50"
    ])

    !!}
>
    {{ $value ?? $slot }}
</label>
