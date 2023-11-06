{{-- props of component --}}
@props([
    'text_color' => 'gray-700',
])

{{-- template --}}
<option {{ $attributes->merge(['class' => "text-$text_color font-normal"]) }}>
    {{ $slot }}
</option>
