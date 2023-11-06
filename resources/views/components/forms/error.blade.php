{{-- props of component --}}
@props(['for', 'textSize'])

{{-- php --}}
@php
    # set text size
    $textSize = \App\Utils\CommonUtils::TEXT_SIZE[$textSize ?? 'sm']
@endphp

{{-- template --}}
@error($for)
    <span class="{!! $textSize !!} text-red-600">{{ $message }}</span>
@enderror
