{{-- define props --}}
@props([
    'person' => null,
    'event' => null,
    ])
<x-layouts.navbars.portal-nav>

    {{-- menu buttons --}}
    <x-slot:menu_buttons>

        {{-- events --}}
        @if((request()->routeIs('portal.event.virtual-card') || request()->routeIs('portal.event.activities')) && $person != null)
            <a href="{{ route('portal.dashboard', $person) }}" wire:navigate class="uppercase text-xs sm:text-md md:text-lg text-lime-900 dark:text-white hover:dark:text-white hover:bg-slate-900 transition ease-in-out duration-300 rounded-sm py-1 px-3 font-normal">Eventos</a>
        @endif

        {{-- activities --}}
        @if(request()->routeIs('portal.event.virtual-card') && $person != null && $event != null)
            <a href="{{ route('portal.event.activities', [$event, $person]) }}" wire:navigate class="uppercase text-xs sm:text-md md:text-lg text-lime-900 dark:text-white hover:dark:text-white hover:bg-slate-900 transition ease-in-out duration-300 rounded-sm py-1 px-3 font-normal">Actividades</a>
        @endif

        {{-- virtual card --}}
        @if(request()->routeIs('portal.event.activities') && $person != null && $event != null)
            <a href="{{ route('portal.event.virtual-card', [$event, $person]) }}" wire:navigate class="uppercase text-xs sm:text-md md:text-lg text-lime-900 dark:text-white hover:dark:text-white hover:bg-slate-900 transition ease-in-out duration-300 rounded-sm py-1 px-3 font-normal">Carnet Virtual</a>
        @endif

    </x-slot:menu_buttons>

</x-layouts.navbars.portal-nav>
