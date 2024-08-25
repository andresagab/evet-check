<div>

    <x-modals.modal-dialog wire:model='open' includeFooter="0">
        <!-- modal title -->
        <x-slot:title>
            <div class="flex flex-row items-center">
                <h3 class="flex-grow font-bold text-lg uppercase text-purple-800 dark:text-purple-300 select-none">{{ __("messages.data.actions.$action", ['resource' => __('messages.models.location.model_name')]) }}</h3>
                <x-buttons.circle-icon-button color="red" title="Click para cerrar" wire:click="$toggle('open')">close</x-buttons.circle-icon-button>
            </div>
        </x-slot:title>
        <hr class="mt-1">
        <!-- modal body -->
        <x-slot:content>
            {{-- section-loader --}}
            <x-loaders.section-loader wire:loading/>

            {{-- form layer --}}
            <form wire:submit.prevent='submit' autocomplete="off" novalidate class="w-full">

                {{-- main layer --}}
                <div class="flex flex-col items-center space-y-6 w-full">

                    {{-- if location have id (when action is edit) --}}
                    @if($location->id)
                        {{-- location data-card --}}
                        <x-sys.locations.data-card :location="$location"/>
                    @endif

                    {{-- person form --}}
                    <x-cards.card title="Formulario" :footer="0" color="stone-100">
                        <x-slot:content>
                            {{-- form-card --}}
                            <x-sys.locations.form-card/>
                        </x-slot:content>
                    </x-cards.card>

                    {{-- action buttons --}}
                    <div class="w-full inline-flex space-x-2 items-center justify-end mt-5">
                        {{-- cancel button --}}
                        <x-buttons.secondary-button wire:click="$toggle('open')" type="button" color="red">Cancelar</x-buttons.secondary-button>
                        {{-- save button --}}
                        <x-buttons.main-button type="submit">Guardar</x-buttons.main-button>
                    </div>

                </div>

            </form>
        </x-slot:content>

    </x-modals.modal-dialog>

</div>
