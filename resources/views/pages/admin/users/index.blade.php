@auth

    <x-layouts.pages.admin-layout>

        {{-- tab title --}}
        <x-slot:title>{{ __('messages.menu.users') }}</x-slot:title>

        {{-- content --}}
        <livewire:admin.users.users-table/>

    </x-layouts.pages.admin-layout>

@endauth
