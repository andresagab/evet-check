@auth
    <x-layouts.pages.admin-layout>

        {{-- tab title --}}
        <x-slot:title>Home</x-slot:title>

        {{-- content --}}
        <div class="flex h-screen w-full">
            <div class="m-auto">
                <h3 class="font-bold text-xl text-green-500">BIENVENIDO AL PANEL DE ADMINISTRACIÓN</h3>
                <h3 class="text-md text-blue-700">{{ \Illuminate\Support\Facades\Auth::user()->name }}</h3>
            </div>
        </div>

    </x-layouts.pages.admin-layout>
@endauth
