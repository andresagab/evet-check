<div class="w-full h-screen grid place-items-center">

    {{-- full-page-loader --}}
    <x-loaders.full-page-loader wire:loading/>

    {{-- form card --}}
    <div class="m-auto bg-gray-100 dark:bg-slate-700 w-1/2 rounded-md p-4">

        <div class="flex flex-col items-center">

            {{-- title --}}
            <h3 class="flex justify-center text-blue-600 dark:text-sky-100 font-bold text-xl">PORTAL DE ASISTENCIA</h3>

            {{-- form --}}
            <form wire:submit="search_person" class="flex flex-col w-full">
                @csrf
                {{-- dni input --}}
                <div class="flex flex-col mt-8 w-full">
                    <x-jet.label for="dni">Número de identificación:</x-jet.label>
                    <x-jet.input wire:model="dni" name="dni" id="dni" type="number" required max="99999999999999999999" min="0" step="1" placeholder="Ingresa tu número de identificación personal" class="w-full" autofocus/>
                    <x-jet.input-error for="dni"/>
                </div>

                {{-- buttons --}}
                <div class="flex items-center justify-end w-full mt-4">
                    {{-- search button --}}
                    <x-buttons.main-button type="submit" class="w-24 font-semibold dark:bg-green-600">Continuar</x-buttons.main-button>
                </div>

            </form>

        </div>

    </div>

</div>
