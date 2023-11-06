{{-- props of component --}}
@props([
    'size' => '22px'
])
<span {{ $attributes->merge(['class' => 'material-icons']) }} style="font-size: {{ $size }}">
    {{ $slot }}
</span>
