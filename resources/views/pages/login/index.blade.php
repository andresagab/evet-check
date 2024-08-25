{{-- if user is not logged --}}
@if(!\Illuminate\Support\Facades\Auth::check())
    <x-layouts.pages.base-layout>

        {{-- tab title --}}
        <x-slot:tabTitle>Inicio de sesión</x-slot:tabTitle>

        <div class="flex w-full min-h-screen">

            <div class="flex flex-col gap-6 m-auto w-full md:w-3/4 lg:w-1/3 p-8 md:p-16">

                <h1 class="font-bold text-2xl md:text-4xl text-white text-center">INICIO DE SESIÓN</h1>

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="bg-slate-800 shadow-md border border-slate-900 rounded-md p-8">

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        {{-- fields --}}
                        <div class="flex flex-col gap-2 items-start space-y-2 w-full">

                            {{-- code --}}
                            <div class="flex flex-col w-full">
                                <label for="code"
                                       class="text-gray-800 dark:text-white antialiased font-semibold text-sm md:text-lg"
                                >
                                    Código:
                                </label>
                                <input
                                    type="text"
                                    name="code"
                                    id="code"
                                    maxlength="30"
                                    placeholder="Ingresa el código de usuario"
                                    class="bg-slate-700 border border-slate-400 px-2 py-1 rounded-sm w-full text-sm md:text-lg font-normal text-slate-300 with focus:border-sky-500 focus:ring-sky-600 transition ease-in-out duration-150"
                                >
                                <x-forms.error for="code" />
                            </div>
                            {{-- password --}}
                            <div class="flex flex-col w-full">
                                <label for="password"
                                       class="text-gray-800 dark:text-white antialiased font-semibold text-sm md:text-lg"
                                >
                                    Contraseña:
                                </label>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    maxlength="30"
                                    placeholder="Ingresa tu contraseña"
                                    class="bg-slate-700 border border-slate-400 px-2 py-1 rounded-sm w-full text-sm md:text-lg font-normal text-slate-300 with focus:border-sky-500 focus:ring-sky-600 transition ease-in-out duration-150"
                                >
                                <x-forms.error for="password" />
                            </div>
                            {{-- remember session --}}
                            <div class="flex flex-col w-full">
                                <label for="remember_me"
                                       class="text-gray-800 dark:text-white antialiased font-medium text-sm md:text-lg"
                                >
                                    Recordar sesión:
                                </label>
                                <input
                                    type="checkbox"
                                    name="remember"
                                    id="remember_me"
                                    placeholder="Ingresa tu contraseña"
                                    class="bg-slate-700 border border-slate-400 px-2 py-1 rounded-sm w-min text-sm md:text-lg font-normal text-purple-400 with focus:border-purple-500 focus:ring-purple-600 transition ease-in-out duration-150"
                                >
                            </div>

                            <x-buttons.main-button
                                type="submit"
                                textSize="md"
                                class="px-4 font-medium rounded-sm"
                                color="blue"
                            >Ingresar</x-buttons.main-button>

                        </div>
                    </form>

                </div>

                <blockquote class="block text-center text-sm break-words text-slate-400">
                    <p>
                        Desarrollador por: <a href="https://www.linkedin.com/in/andresangulodev/" target="_blank" title="Click para ver el perfil del autor principal" class="text-blue-600 dark:text-blue-400 hover:underline transition ease-in-out duration-150">Andrés Angulo - Software Developer</a>
                    </p>
                    <a href="https://github.com/andresagab/evet-check?tab=MIT-1-ov-file#readme" target="_blank" title="Click para ver la licencia" class="text-center text-sm break-words text-slate-300 hover:underline">MIT License</a>
                </blockquote>

            </div>

        </div>

    </x-layouts.pages.base-layout>
@endif
