<div class="ml-3 relative">
    <x-jet.dropdown align="right" width="48">
        <x-slot name="trigger">
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-lime-700 hover:border-emerald-700 transition duration-300 focus:shadow-md hover:shadow-md">
                    <img class="h-8 w-8 md:h-12 md:w-12 rounded-full object-cover" src="{{ Auth::user()->getProfilePhoto() }}" alt="{{ Auth::user()->name }}" />
                </button>
            @else
                <span class="inline-flex rounded-md">
                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-700 dark:hover:text-slate-100 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 dark:active:bg-gray-700 dark:focus:bg-gray-700 transition ease-in-out duration-150">
                        {{ Auth::user()->name }}

                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </span>
            @endif
        </x-slot>

        <x-slot name="content">
            <!-- Account Management -->
            <div class="block px-4 py-2 text-xs text-gray-400 select-none">
                {{ __('messages.menu.manage_account') }}
            </div>

            <x-jet.dropdown-link href="{{ route('profile.show') }}">
                {{ __('messages.menu.profile') }}
            </x-jet.dropdown-link>

            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <x-jet.dropdown-link href="{{ route('api-tokens.index') }}">
                    {{ __('API Tokens') }}
                </x-jet.dropdown-link>
            @endif

            <div class="border-t border-gray-200"></div>

            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf

                <x-jet.dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                    {{ __('messages.menu.logout') }}
                </x-jet.dropdown-link>
            </form>
        </x-slot>
    </x-jet.dropdown>
</div>
