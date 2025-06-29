<footer class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Branding -->
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <svg class="w-10 h-10 text-green-600 dark:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="text-2xl font-bold text-gray-800 dark:text-white">EventCheck</span>
                </div>
                <p class="text-gray-500 dark:text-gray-400 text-sm">
                    Plataforma de gestión de eventos para la Universidad de Nariño.
                </p>
            </div>

            <!-- Links -->
            <div class="grid grid-cols-2 gap-8 col-span-2">
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 tracking-wider uppercase dark:text-gray-400">Invitan</h3>
                    <ul role="list" class="mt-4 space-y-2">
                        <li title="Universidad de Nariño">
                            <img src="{{ asset('assets/img/udenar_logo_white.png') }}" class="h-12 bg-gray-200 dark:bg-gray-800 p-2 rounded-lg">
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 tracking-wider uppercase dark:text-gray-400">Licencia</h3>
                    <ul role="list" class="mt-4 space-y-2 text-sm">
                        {{-- <li>
                            <a href="mailto:informatica@udenar.edu.co" class="text-gray-600 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400">
                                informatica@udenar.edu.co
                            </a>
                        </li> --}}
                        <li>
                            <a href="https://github.com/andresagab/evet-check?tab=MIT-1-ov-file#readme" target="_blank" class="text-gray-600 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400">
                                Licencia MIT
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6 text-sm text-gray-500 dark:text-gray-400 flex flex-col sm:flex-row justify-between items-center">
            <p>&copy; {{ date('Y') }} EventCheck. Todos los derechos reservados.</p>
            <p class="mt-2 sm:mt-0">
                Desarrollado en colaboración con <a href="https://www.linkedin.com/in/andresangulodev/" target="_blank" class="text-green-600 dark:text-green-400 hover:underline">Andrés Angulo</a>
            </p>
        </div>
    </div>
</footer>
