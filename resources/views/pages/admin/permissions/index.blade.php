@auth

    <x-layouts.pages.admin-layout>

        {{-- tab title --}}
        <x-slot:title>{{ _('messages.menu.permissions')}}</x-slot:title>

        {{-- content --}}
        <livewire:admin.permissions.permissions-table/>
       


    </x-layouts.pages.admin-layout>

@endauth
