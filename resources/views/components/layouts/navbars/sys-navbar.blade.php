<x-layouts.navbars.base-nav>

    {{-- menu buttons --}}
    <x-slot:menu_buttons>

        {{-- categories --}}
        @ability('*', 'categories')
            <x-buttons.a-button href="{{ route('sys.categories') }}" color="emerald" textSise="sm">{{__('messages.menu.categories')}}</x-buttons.a-button>
        @endability

        {{-- departments --}}
        @ability('*', 'departments')
            <x-buttons.a-button href="{{ route('sys.departaments') }}" color="emerald" textSise="sm">{{__('messages.menu.departments')}}</x-buttons.a-button>
        @endability

        {{-- people --}}
        @ability('*', 'people')
            <x-buttons.a-button href="{{ route('sys.people') }}" color="emerald" textSise="sm">{{__('messages.menu.people')}}</x-buttons.a-button>
        @endability

    </x-slot:menu_buttons>

</x-layouts.navbars.base-nav>
