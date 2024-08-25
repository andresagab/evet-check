<x-layouts.pages.admin-layout>

    {{-- php code --}}
    @php

        $user = \Illuminate\Support\Facades\Auth::user();

    @endphp

    {{-- tab title --}}
    <x-slot:title>Home</x-slot:title>

    {{-- content --}}
    <x-layouts.pages.content.base-content-page-layout>

        <div class="bg-slate-800 w-full p-8 rounded-md shadow-md border-border-slate-900">
            <h3 class="font-bold text-xl md:text-2xl lg:text-4xl text-green-300">BIENVENIDO AL PANEL DE ADMINISTRACIÓN</h3>
            <h3 class="text-lg md:text-xl lg:text-2xl text-slate-100">{{ $user->person ? $user->person->getFullName() : $user->name }}</h3>
        </div>

        {{-- dashboard --}}
        <x-sys.dashboard.sys-dashboard />

    </x-layouts.pages.content.base-content-page-layout>

</x-layouts.pages.admin-layout>
