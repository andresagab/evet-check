{{-- props --}}
@props([
    'tag' => 'span',
    'text_size',
    'color' => 'red',
])

{{-- php code --}}
@php

    # using
    use \App\Utils\CommonUtils;

    # set text size
    $text_size = CommonUtils::TEXT_SIZE[$text_size ?? 'sm'];

@endphp

{{-- template --}}
<{!! $tag !!} {{ $attributes->merge(['class' => "$text_size text-$color-700 dark:text-$color-300"]) }}>{{ $slot }}</{!! $tag !!}>
