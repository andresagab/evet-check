{{-- define props of component --}}
@props([
    'textSize',
    'disabled' => 0,
    'required_state' => 1,
    'include_first_option' => 1,
    'data' => [],
    'special_key_value' => null,
    'special_key_content' => null,
    'option_class' => 'text-gray-700 font-normal',
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
<select
    {{-- disabled attribute --}}
    {{ $disabled ? 'disabled' : null }}
    {{-- include required directive --}}
    {{ $required_state ? 'required' : null }}
    {{-- merge --}}
    {!!

    $attributes->merge([
        'class' => "px-2 py-1 $textSize w-full bg-white-200 rounded-md focus:outline-none focus:border focus:border-indigo-700 font-normal text-gray-900 transition ease-in-out duration-300",
        'id' => $modelReference ?? null,
        'name' => $modelReference ?? null,
    ])

    !!}
>

    {{-- select a option --}}
    @if($include_first_option)
        <option>Seleccione una opción</option>
    @endif

    {{-- options --}}

    {{-- if $data have items --}}
    @if(count($data) > 0)

        {{-- loop of $data --}}
        @foreach($data as $key => $item)

            {{-- php --}}
            @php

            # define $value with $special_key_value if it's not null, else define with current item $key
            $value = $special_key_value ? $item[$special_key_value] : $key;
            # define $content with $special_key_content if it's not null, else define with current $item
            $content = $special_key_content ? $item[$special_key_content] : $item;

            @endphp

            {{-- option --}}
            <option value="{{ $value }}" class="{!! $option_class !!}">{{ __($content) }}</option>

        @endforeach

    {{-- else, enable slot to put custom options --}}
    @else
        {{ $slot }}
    @endif

</select>
