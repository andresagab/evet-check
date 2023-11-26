<div>
    <div class="w-full h-screen grid place-items-center">

        {{-- full-page-loader --}}
        <x-loaders.full-page-loader wire:loading/>

        <div class="flex flex-col items-center justify-center p-8 md:p-16">

            {{-- carrer --}}
            <h1 class="font-bold text-3xl md:text-5xl text-violet-500 dark:text-white text-center">LICENCIATURA EN INFORMÁTICA</h1>
            {{-- university --}}
            <h1 class="font-semibold text-xl md:text-3xl text-violet-500 dark:text-slate-300 text-center mt-2">Universidad de Nariño</h1>

            {{-- form card --}}
            <div class="flex flex-col items-center mt-6">

                {{-- title --}}
                <h3 class="flex text-center text-blue-600 dark:text-white font-bold text-xl md:text-2xl">PORTAL DE ASISTENTES</h3>

                {{-- form --}}
                <form wire:submit="search_person" class="flex flex-col w-full">
                    @csrf
                    {{-- dni input --}}
                    <div class="flex flex-col mt-8 w-full">
                        <x-jet.label for="dni">Número de identificación:</x-jet.label>
                        <x-jet.input wire:model="dni" name="dni" id="dni" type="number" required max="99999999999999999999" min="0" step="1" placeholder="Ingresa tu número de identificación personal" class="w-full text-sm md:text-md" autofocus/>
                        <x-jet.input-error for="dni"/>
                    </div>

                    {{-- buttons --}}
                    <div class="flex items-center justify-start w-full mt-8">
                        {{-- search button --}}
                        <x-buttons.main-button type="submit" class="w-24 font-semibold dark:bg-green-600">Continuar</x-buttons.main-button>
                    </div>

                </form>

            </div>

        </div>

    </div>

    <x-layouts.footers.portal-footer/>

</div>
