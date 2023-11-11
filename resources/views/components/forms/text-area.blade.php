{{-- define props of component --}}
@props([
    'textSize',
    'disabled' => 0,
    'required_state' => 1,
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
<textarea
    {{-- disabled attribute --}}
    {{ $disabled ? 'disabled' : null }}
    {{-- include required directive --}}
    {{ $required_state ? 'required' : null }}
    {{-- merge --}}
    {!!

    $attributes->merge([
        # 'class' => 'peer block w-full appearance-none border-0 border-b border-gray-500 bg-transparent py-2.5 px-0 text-sm text-gray-900 focus:border-blue-600 focus:outline-none focus:ring-0',
        'class' => "px-2 py-1 $textSize w-full bg-white-200 dark:bg-gray-900 rounded-md focus:outline-none focus:border focus:border-indigo-700 font-normal text-gray-900 dark:text-stone-100 appearance-none transition ease-in-out duration-300",
        'id' => $modelReference ?? null,
        'name' => $modelReference ?? null,
    ])

    !!}
>
</textarea>
