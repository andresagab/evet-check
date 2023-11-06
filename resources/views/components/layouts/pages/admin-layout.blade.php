<x-layouts.pages.base-layout>

    {{-- tab title --}}
    <x-slot:tabTitle>{{ strlen($title) > 0 ? "$title | Panel de administración" : null }}</x-slot:tabTitle>

    {{-- header --}}
    @section('header')
        <x-layouts.navbars.admin-navbar/>
    @endsection

    {{-- page layer --}}
    {{--<div class="min-h-screen w-full bg-gray-100 text-gray-700" x-data="{ asideOpen: true }">

        --}}{{-- header --}}{{--
        <x-layouts.navbars.admin-navbar/>

        --}}{{-- content layer --}}{{--
        <div class="flex h-full">

            --}}{{-- aside --}}{{--
            <aside class="flex w-72 h-full flex-col space-y-2 border-r-2 border-gray-200 bg-white p-2" style="height: 90.5vh"
                   x-show="asideOpen">
                <a href="#" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                    <span class="text-2xl">
                        <x-utils.icon>home</x-utils.icon>
                    </span>
                    <span>Dashboard</span>
                </a>

                <a href="#" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                    <span class="text-2xl"><i class="bx bx-cart"></i></span>
                    <span>Cart</span>
                </a>

                <a href="#" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                    <span class="text-2xl"><i class="bx bx-shopping-bag"></i></span>
                    <span>Shopping</span>
                </a>

                <a href="#" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                    <span class="text-2xl"><i class="bx bx-heart"></i></span>
                    <span>My Favourite</span>
                </a>

                <a href="#" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                    <span class="text-2xl"><i class="bx bx-user"></i></span>
                    <span>Profile</span>
                </a>
            </aside>

            --}}{{-- content --}}{{--
            <div class="w-full p-4">
                {{ $slot }}
            </div>

        </div>

    </div>--}}

    {{-- content --}}
    {{ $slot }}

</x-layouts.pages.base-layout>
