{{-- define props of component --}}
@props([
    'textSize',
    'disabled' => 0,
    'required_state' => 0,
    'color' => 'green',
    'size' => 5,
    ])

{{-- php --}}
@php

    # if exist $attributes
    if (isset($attributes))
    {
        # get model reference
        $modelReference = $attributes->whereStartsWith('wire:model')->first();
    }

    # set text size
    $textSize = \App\Utils\CommonUtils::TEXT_SIZE[$textSize ?? 'sm']

@endphp

{{-- template --}}
<input type="checkbox"
    {{-- disabled attribute --}}
    {{ $disabled ? 'disabled' : null }}
    {{-- include required directive --}}
    {{ $required_state ? 'required' : null }}
    {{-- merge --}}
    {!!

    $attributes->merge([
        'class' => "form-checkbox h-$size w-$size $textSize text-$color-600 hover:text-$color-800 hover:shadow-sm transition ease-in-out duration-300 rounded-sm",
        'id' => $modelReference ?? null,
        'name' => $modelReference ?? null,
    ])

    !!}
>
