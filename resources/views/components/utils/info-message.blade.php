{{-- define props of component --}}
@props([
    'title',
    'main_text',
    'secondary_text',
    'extra',
])

{{-- template --}}
<div
    {{
        $attributes->merge([
            'class' => 'flex flex-col items-center justify-center'
        ])
    }}
>
    {{-- title --}}
    <h3 {{ $title->attributes->class(["font-semibold text-red-600 text-md"]) }}>{{ $title }}</h3>
    {{-- main_text --}}
    <p {{ $main_text->attributes->class(["font-semibold text-sm text-gray-800"]) }}>{{ $main_text }}</p>
    {{-- secondary_text --}}
    <p {{ $secondary_text->attributes->class(["font-normal text-xs text-gray-700"]) }}>{{ $secondary_text }}</p>
    {{-- EXTRA --}}
    {{-- if extra is not null --}}
    {{ $extra ?? null }}
</div>
