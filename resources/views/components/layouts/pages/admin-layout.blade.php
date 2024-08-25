<x-layouts.pages.base-layout>

    {{-- tab title --}}
    <x-slot:tabTitle>{{ strlen($title) > 0 ? "$title | Panel de administración" : null }}</x-slot:tabTitle>

    {{-- header --}}
    @section('header')
        <x-layouts.navbars.admin-navbar/>
    @endsection

    {{-- content --}}
    {{ $slot }}

    {{-- footer --}}
    @section('footer')
        <x-layouts.footers.admin-footer />
    @endsection

</x-layouts.pages.base-layout>
