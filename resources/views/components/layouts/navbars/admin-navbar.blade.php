<x-layouts.navbars.base-nav>

    {{-- menu buttons --}}
    <x-slot:menu_buttons>

        {{-- information system --}}
        @ability('*', 'users')
            <x-buttons.a-button wire:navigate.hover href="{{ route('sys.home') }}" color="teal" textSise="md">{{ __('messages.menu.sys') }}</x-buttons.a-button>
        @endability

        {{-- home --}}
        <x-buttons.a-button wire:navigate.hover href="{{ route('admin.home') }}" color="slate" textSise="md">{{__('messages.menu.home')}}</x-buttons.a-button>

        {{-- users --}}
        @ability('*', 'users')
            <x-buttons.a-button wire:navigate.hover href="{{ route('admin.users') }}" color="slate" textSise="md">{{ __('messages.menu.users') }}</x-buttons.a-button>
        @endability

        {{-- permissions --}}
        @ability('*', 'permissions')
            <x-buttons.a-button wire:navigate.hover href="{{ route('admin.permissions') }}" color="slate" textSise="md">{{ __('messages.menu.permissions') }}</x-buttons.a-button>
        @endability

        {{-- roles --}}
        @ability('*', 'roles')
            <x-buttons.a-button wire:navigate.hover href="{{ route('admin.roles') }}" color="slate" textSise="md">{{ __('messages.menu.roles') }}</x-buttons.a-button>
        @endability

    </x-slot:menu_buttons>

</x-layouts.navbars.base-nav>
