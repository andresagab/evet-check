{{-- if user is not logged --}}
@if(!\Illuminate\Support\Facades\Auth::check())
    <x-layouts.pages.base-layout>

        {{-- tab title --}}
        <x-slot:tabTitle>Inicio de sesión</x-slot:tabTitle>

        {{-- content page --}}
        <section class="flex w-full h-screen">

            <div class="m-auto">

                <x-jet.validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ session('status') }}
                    </div>
                @endif

                <h3 class="text-gray-900 dark:text-gray-100 antialiased font-semibold mb-3">INICIO DE SESIÓN</h3>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    {{-- fields --}}
                    <div class="flex flex-col items-start space-y-2">

                        {{-- code --}}
                        <div class="flex flex-col items-start">
                            <label for="code" class="text-gray-800 dark:text-gray-100 antialiased">Código:</label>
                            <input type="text" name="code" id="code" maxlength="30" placeholder="Ingresa el código de usuario" class="bg-zinc-100 px-2 py-1 rounded-md">
                        </div>
                        {{-- password --}}
                        <div class="flex flex-col items-start">
                            <label for="password" class="text-gray-800 dark:text-gray-100 antialiased">Contraseña:</label>
                            <input type="password" name="password" id="password" maxlength="255" placeholder="Ingresa tu contraseña" class="bg-zinc-100 px-2 py-1 rounded-md">
                        </div>
                        {{-- remenber session --}}
                        <div class="block mt-4">
                            <label for="remember_me" class="flex items-center">
                                <x-jet.checkbox id="remember_me" name="remember" />
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-200">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                    </div>
                    {{-- actions --}}
                    <div class="flex flex-col justify-end mt-3 space-y-1">
                        {{-- password reset --}}
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 dark:text-gray-200 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                        {{-- login --}}
                        <button type="submit" class="bg-orange-400 rounded-md p-2">Ingresar</button>
                    </div>
                </form>

            </div>

        </section>

    </x-layouts.pages.base-layout>
@endif
