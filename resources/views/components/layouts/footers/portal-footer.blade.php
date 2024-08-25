{{-- template --}}
<div class="w-full min-h-min flex items-center justify-center bg-gray-950 bg-gradient-to-b from-gray-900">
    <div class="md:w-2/3 w-full px-4 py-10 text-white flex flex-col">
        {{-- invitation --}}
        <div class="flex flex-col space-y-12">
            <div class="w-full text-6xl font-semibold">
                <h1 class="w-full md:w-2/3">Invitan</h1>
            </div>
            <div class="flex flex-row space-x-20 items-center justify-start">
                <img src="{{ asset('assets/img/udenar_logo_white.png') }}" width="100px">
                <img src="{{ asset('assets/img/licinfo_logo_white.png') }}" width="100px">
                <img src="{{ asset('assets/img/mtic_logo_white.png') }}" width="100px">
            </div>
        </div>
        <div class="w-full text-5xl font-semibold mt-12">
            <h1 class="w-full md:w-2/3">Gracias por ser parte de esta iniciativa</h1>
        </div>
        <div class="flex mt-8 flex-col md:flex-row md:justify-between">
            <p class="w-full md:w-2/3 text-gray-400">Esperamos poder ayudarte en todo lo posible, para mayor información visita nuestra página web o comunícate a través de las siguientes opciones:</p>
            <div class="w-auto pt-6 md:pt-0">
                <a href="https://www.udenar.edu.co/congreso-repetic-viii/" target="_blank" class="bg-violet-500 hover:bg-violet-400 transition ease-in-out duration-300 justify-center text-center rounded-lg shadow px-10 py-3 flex items-center">Más información</a>
            </div>
        </div>
        {{-- contact info --}}
        <div class="flex flex-col space-y-2 mt-4">
            {{-- email --}}
            <div class="flex flex-row space-x-2">
                <x-utils.icon class="text-gray-500">email</x-utils.icon>
                <a href="mailto:informatica@udenar.edu.co" class="text-gray-400">informatica@udenar.edu.co</a>
            </div>
            {{-- phone --}}
            <div class="flex flex-row space-x-2">
                <x-utils.icon class="text-gray-500">phone</x-utils.icon>
                <span class="text-gray-400">317 252 0324</span>
            </div>
        </div>
        <div class="flex flex-col mt-8">
            <hr class="border-gray-600"/>
            <blockquote class="block text-center text-sm break-words text-slate-400 mt-4">
                <p>
                    Desarrollador por: <a href="https://www.linkedin.com/in/andresangulodev/" target="_blank" title="Click para ver el perfil del autor principal" class="text-blue-600 dark:text-blue-400 hover:underline transition ease-in-out duration-150">Andrés Angulo - Software Developer</a>
                </p>
                <a href="https://github.com/andresagab/evet-check?tab=MIT-1-ov-file#readme" target="_blank" title="Click para ver la licencia" class="text-center text-sm break-words text-slate-300 hover:underline">MIT License {{ date('Y') }}</a>
            </blockquote>
        </div>
    </div>
</div>
