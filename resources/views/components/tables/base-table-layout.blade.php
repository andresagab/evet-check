@props([
    'color' => 'lime',
])

{{-- template --}}
<div {{
        $attributes->merge([
            'class' => "w-full border border-$color-300 dark:border-slate-700 rounded-md shadow-sm shadow-$color-500/30 dark:shadow-stone-700/30 hover:shadow-md hover:shadow-$color-500/40 dark:hover:shadow-stone-700/40 transition-all ease-in-out duration-300 overflow-x-auto"
        ])
    }}
>
    {{ $slot }}
</div>
