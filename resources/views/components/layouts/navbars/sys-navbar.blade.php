<x-layouts.navbars.base-nav>

    {{-- menu buttons --}}
    <x-slot:menu_buttons>

        {{-- admin panel --}}
        @ability('*', ['users', 'permissions', 'roles'])
            <x-buttons.a-button wire:navigate.hover href="{{ route('admin.home') }}" color="sky" textSise="md">{{__('messages.menu.admin')}}</x-buttons.a-button>
        @endability

        {{-- people --}}
        @ability('*', 'people')
            <x-buttons.a-button wire:navigate.hover href="{{ route('sys.people') }}" color="slate" textSise="md">{{__('messages.menu.people')}}</x-buttons.a-button>
        @endability

        {{-- events --}}
        @ability('*', 'events')
            <x-buttons.a-button wire:navigate.hover href="{{ route('sys.events') }}" color="slate" textSise="md">{{__('messages.menu.events')}}</x-buttons.a-button>
        @endability

        {{-- activities --}}
        @ability('*', 'activities')
            <x-buttons.a-button wire:navigate.hover href="{{ route('sys.activities') }}" color="slate" textSise="md">{{__('messages.menu.activities')}}</x-buttons.a-button>
        @endability

        {{-- locations --}}
        @ability('*', 'locations')
            <x-buttons.a-button wire:navigate.hover href="{{ route('sys.locations') }}" color="slate" textSise="md">{{__('messages.menu.locations')}}</x-buttons.a-button>
        @endability

    </x-slot:menu_buttons>

</x-layouts.navbars.base-nav>
