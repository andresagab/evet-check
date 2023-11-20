<x-layouts.navbars.base-nav>

    {{-- menu buttons --}}
    <x-slot:menu_buttons>

        {{-- people --}}
        @ability('*', 'people')
            <x-buttons.a-button href="{{ route('sys.people') }}" color="slate" textSise="sm">{{__('messages.menu.people')}}</x-buttons.a-button>
        @endability

        {{-- events --}}
        @ability('*', 'events')
            <x-buttons.a-button href="{{ route('sys.events') }}" color="slate" textSise="sm">{{__('messages.menu.events')}}</x-buttons.a-button>
        @endability

        {{-- activities --}}
        @ability('*', 'activities')
            <x-buttons.a-button href="{{ route('sys.activities') }}" color="slate" textSise="sm">{{__('messages.menu.activities')}}</x-buttons.a-button>
        @endability

    </x-slot:menu_buttons>

</x-layouts.navbars.base-nav>
