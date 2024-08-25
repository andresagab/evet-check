@props(['menu_buttons'])
<header class="w-full">
    <nav class="flex flex-row items-center bg-lime-500 dark:bg-slate-800 shadow-md shadow-lime-700/60 dark:shadow-gray-700/60 dark:border-b dark:border-gray-700 w-full p-6">

        {{-- app name --}}
        <div class="flex-grow flex-row items-center">
            <a href="#" class="uppercase text-xl md:text-2xl text-lime-900 dark:text-stone-50 font-bold">{{ config('app.name', 'Resseeds-UDENAR') }}</a>
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
