{{-- props of component --}}
@props([
    'flex_type' => 'flex-col'
])

{{-- template --}}
<div {{

    $attributes->merge([
        # 'class' => "relative z-0"
        'class' => "flex $flex_type items-start w-full"
    ])

    }}
>
    {{ $slot }}
</div>
