<div>
    {{-- full-page-loader --}}
    <x-loaders.full-page-loader wire:loading />

    <main class="bg-gray-50 dark:bg-gray-900">
        <!-- Hero Section -->
        <div class="relative overflow-hidden">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1579546929518-9e396f3cc809?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80"
                    alt="Abstract background" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-green-800 mix-blend-multiply"></div>
            </div>
            <div class="relative max-w-4xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Portal de Eventos Udenar
                </h1>
                <p class="mt-6 text-xl text-green-100">
                    Bienvenido al Módulo de Asistentes, por favor, ingresa tu número de identificación para unirte a nuestros eventos.
                </p>
            </div>
        </div>

        <!-- Form Section -->
        <div id="check-in" class="py-16 bg-gray-100 dark:bg-gray-950/50 sm:py-24">
            <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8">
                    <h3 class="text-center text-gray-800 dark:text-white font-bold text-2xl mb-2">
                        Eventos y Actividades
                    </h3>
                    <p class="text-center text-sm text-gray-600 dark:text-gray-400 mb-8">
                        Ingresa tu número de identificación para continuar.
                    </p>

                    <form wire:submit="search_person" class="flex flex-col w-full">
                        @csrf
                        <div>
                            <x-jet.label for="dni" class="dark:text-gray-300 font-semibold">Número de identificación</x-jet.label>
                            <x-jet.input wire:model="dni" name="dni" id="dni" type="number" required
                                max="99999999999999999999" min="0" step="1" placeholder="Ej: 1085..."
                                class="w-full text-sm md:text-md mt-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                autofocus />
                            <x-jet.input-error for="dni" class="mt-2" />
                        </div>

                        <div class="flex flex-col items-center w-full mt-8">
                            <x-buttons.main-button type="submit"
                                class="w-full justify-center font-semibold text-lg bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 transition-all duration-300 ease-in-out">
                                Continuar
                            </x-buttons.main-button>
                            <div class="flex items-center mt-4">
                                <p class="text-sm text-gray-600 dark:text-gray-400">¿No estás registrado?</p>
                                <x-buttons.secondary-button wire:click="open_register_modal"
                                    title="Click para registrarte"
                                    class="text-green-600 dark:text-green-400 hover:underline ml-2 font-semibold">
                                    Regístrate aquí
                                </x-buttons.secondary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Event History Section -->
        <livewire:portal.event-history />

    </main>

    <!-- Footer -->
    <x-layouts.footers.portal-footer/>

    <!-- Modals -->
    <livewire:portal.register/>
</div>
