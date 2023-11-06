@props(['menu_buttons'])
<header class="w-full">
    <nav class="flex flex-row items-center bg-lime-500 shadow-md shadow-lime-700/60 w-full px-2 py-3">

        {{-- app name --}}
        <div class="flex-grow flex-row items-center">
            <a href="{{ route('admin.home') }}" class="uppercase text-lime-900 font-bold">{{ config('app.name', 'Resseeds-UDENAR') }}</a>
        </div>

        {{-- menu bar --}}
        <div class="flex flex-row items-center space-x-2">

            {{-- menu buttons --}}
            {{ $menu_buttons ?? null }}

            {{-- settings dropdown --}}
            <x-layouts.navbars.items.manage-account/>

        </div>

    </nav>
</header>
