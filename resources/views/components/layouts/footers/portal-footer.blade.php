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
            <div class="flex flex-col space-y-3">
                <span class="font-semibold text-slate-100 mt-2 text-sm">Desarrollado por:</span>
                <div class="flex flex-row items-center space-x-2">
                    <span class="font-normal text-sm text-slate-300">Andrés Angulo</span>
                    <a href="https://www.linkedin.com/in/andres-angulo-372850165/" target="_blank" title="Ir al perfil en Linkedin">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0,0,256,256">
                            <g transform=""><g fill="#000000" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,256v-256h256v256z" id="bgRectangle"></path></g><g fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M41,4h-32c-2.76,0 -5,2.24 -5,5v32c0,2.76 2.24,5 5,5h32c2.76,0 5,-2.24 5,-5v-32c0,-2.76 -2.24,-5 -5,-5zM17,20v19h-6v-19zM11,14.47c0,-1.4 1.2,-2.47 3,-2.47c1.8,0 2.93,1.07 3,2.47c0,1.4 -1.12,2.53 -3,2.53c-1.8,0 -3,-1.13 -3,-2.53zM39,39h-6c0,0 0,-9.26 0,-10c0,-2 -1,-4 -3.5,-4.04h-0.08c-2.42,0 -3.42,2.06 -3.42,4.04c0,0.91 0,10 0,10h-6v-19h6v2.56c0,0 1.93,-2.56 5.81,-2.56c3.97,0 7.19,2.73 7.19,8.26z"></path></g></g></g>
                        </svg>
                    </a>
                </div>
            </div>
            <hr class="border-gray-600 mt-4"/>
            <p class="w-full text-center my-12 text-gray-400">Copyright © {{ now()->format('Y') }} Licenciatura en Informática - Universidad de Nariño</p>
        </div>
    </div>
</div>
