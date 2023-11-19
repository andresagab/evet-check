<x-layouts.navbars.base-nav>

    {{-- menu buttons --}}
    <x-slot:menu_buttons>

        {{-- people --}}
        @ability('*', 'people')
                <x-buttons.a-button href="{{ route('sys.people') }}" color="slate" textSise="sm">{{__('messages.menu.people')}}</x-buttons.a-button>
        @endability

    </x-slot:menu_buttons>

</x-layouts.navbars.base-nav>
