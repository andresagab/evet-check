{{-- template --}}
<div class="w-full min-h-screen flex items-center justify-center bg-slate-950">
    <div class="md:w-2/3 w-full px-4 text-white flex flex-col">
        {{-- invitation --}}
        <div class="flex flex-col space-y-12">
            <div class="w-full text-7xl font-bold">
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
            <p class="w-full text-center my-12 text-gray-400">Copyright © {{ now()->format('Y') }} Licenciatura en Informática - Universidad de Nariño</p>
        </div>
    </div>
</div>
