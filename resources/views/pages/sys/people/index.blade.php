@auth

    <x-layouts.pages.sys-layout>

        {{-- tab title --}}
        <x-slot:title>{{ __('messages.menu.people') }}</x-slot:title>

        {{-- content --}}
        <livewire:sys.people.people-table/>

    </x-layouts.pages.sys-layout>

@endauth
