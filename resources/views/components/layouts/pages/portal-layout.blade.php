{{-- define props --}}
@props([
    'person' => null,
    'event' => null,
    ])

{{-- template --}}
<x-layouts.pages.base-layout>

    {{-- tab title --}}
    <x-slot:tabTitle>{{ strlen($title) > 0 ? "$title | Portal de asistentes" : null }}</x-slot:tabTitle>

    {{-- header --}}
    @section('header')
        <x-layouts.navbars.portal-navbar :person="$person" :event="$event"/>
    @endsection

    {{-- content --}}
    {{ $slot }}

    @section('footer')
        <x-layouts.footers.portal-footer/>
    @endsection

</x-layouts.pages.base-layout>
