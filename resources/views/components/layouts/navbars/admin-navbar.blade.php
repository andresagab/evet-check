<x-layouts.navbars.base-nav>

    {{-- menu buttons --}}
    <x-slot:menu_buttons>

        {{-- users --}}
        @ability('*', 'users')
            <x-buttons.a-button href="{{ route('admin.users') }}" color="slate" textSise="sm">{{ __('messages.menu.users') }}</x-buttons.a-button>
        @endability

        {{-- permissions --}}
        @ability('*', 'permissions')
            {{--<x-buttons.a-button href="{{ route('admin.permissions') }}" color="slate" textSise="sm">{{ __('messages.menu.permissions') }}</x-buttons.a-button>--}}
        @endability

        {{-- roles --}}
        @ability('*', 'roles')
            <x-buttons.a-button href="{{ route('admin.roles') }}" color="slate" textSise="sm">{{ __('messages.menu.roles') }}</x-buttons.a-button>
        @endability

    </x-slot:menu_buttons>

</x-layouts.navbars.base-nav>
