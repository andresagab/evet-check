@props(['menu_buttons'])
<header class="w-full fixed z-10">
    <nav class="flex flex-row items-center bg-lime-500 dark:bg-slate-950 shadow-md w-full px-2 py-3">

        {{-- app name --}}
        <div class="w-full flex flex-row space-x-4 items-center justify-center">
            <a href="{{ route('portal.home') }}" class="uppercase text-xs sm:text-md md:text-lg text-lime-900 dark:text-white hover:dark:text-white hover:bg-slate-900 transition ease-in-out duration-300 rounded-sm py-1 px-3 font-normal">Inicio</a>
            {{-- menu buttons --}}
            {{ $menu_buttons ?? null }}
        </div>

    </nav>
</header>
