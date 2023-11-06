@props([
    'color' => 'lime',
])

{{-- template --}}
<div {{
        $attributes->merge([
            'class' => "w-full border border-$color-300 rounded-md shadow-sm shadow-$color-500/30 hover:shadow-md hover:shadow-$color-500/40 transition-all ease-in-out duration-300 overflow-x-auto"
        ])
    }}
>
    {{ $slot }}
</div>
