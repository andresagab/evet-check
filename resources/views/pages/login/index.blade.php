{{-- if user is not logged --}}
@if(!\Illuminate\Support\Facades\Auth::check())
    <x-layouts.pages.base-layout>

        {{-- tab title --}}
        <x-slot:tabTitle>Inicio de sesión</x-slot:tabTitle>

        <div class="w-full min-h-screen bg-gray-50 dark:bg-gray-900 md:grid md:grid-cols-2">
            <!-- Left Side: Branding -->
            <div class="hidden md:flex flex-col items-center justify-center bg-green-700 p-12 text-white">
                <div class="text-center">
                    <svg class="w-32 h-32 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <a href="{{ route('portal.home') }}" class="text-4xl font-bold">EventCheck</a>
                    <p class="mt-2 text-green-200">Plataforma de Gestión de Eventos</p>
                </div>
            </div>

            <!-- Right Side: Form -->
            <div class="flex flex-col justify-center items-center h-screen bg-gray-50 dark:bg-gray-900 p-4">

                <div class="w-full max-w-md">

                    <div class="text-center mb-8">
                        <h1 class="font-bold text-3xl text-gray-800 dark:text-white">INICIO DE SESIÓN</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">Accede a tu panel de control.</p>
                    </div>

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900/50 border border-green-200 dark:border-green-800 rounded-lg p-4 text-center">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8">
                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf
                            {{-- code --}}
                            <div>
                                <x-jet.label for="code" class="dark:text-gray-300 font-semibold">Código</x-jet.label>
                                <x-jet.input name="code" id="code" type="text" maxlength="30"
                                    placeholder="Ingresa tu código de usuario" required
                                    class="w-full text-sm md:text-md mt-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                                <x-forms.error for="code" />
                            </div>
                            {{-- password --}}
                            <div>
                                <x-jet.label for="password" class="dark:text-gray-300 font-semibold">Contraseña</x-jet.label>
                                <x-jet.input name="password" id="password" type="password" maxlength="30"
                                    placeholder="Ingresa tu contraseña" required
                                    class="w-full text-sm md:text-md mt-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                                <x-forms.error for="password" />
                            </div>
                            {{-- remember session --}}
                            <div class="flex items-center">
                                <x-jet.checkbox id="remember_me" name="remember" />
                                <label for="remember_me" class="ml-2 text-sm text-gray-600 dark:text-gray-300">
                                    Recordar sesión
                                </label>
                            </div>

                            <x-buttons.main-button type="submit"
                                class="w-full justify-center font-semibold text-lg bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 transition-all duration-300 ease-in-out">
                                Ingresar
                            </x-buttons.main-button>

                        </form>
                    </div>

                    <blockquote class="mt-8 block text-center text-sm break-words text-slate-400">
                        <p>
                            Desarrollado por: <a href="https://www.linkedin.com/in/andresangulodev/" target="_blank"
                                title="Click para ver el perfil del autor principal"
                                class="text-green-600 dark:text-green-400 hover:underline transition ease-in-out duration-150">Andrés
                                Angulo - Software Developer</a>
                        </p>
                        <a href="https://github.com/andresagab/evet-check?tab=MIT-1-ov-file#readme" target="_blank"
                            title="Click para ver la licencia"
                            class="text-center text-sm break-words text-slate-300 hover:underline">MIT License</a>
                    </blockquote>
                </div>
            </div>
        </div>

    </x-layouts.pages.base-layout>
@endif
