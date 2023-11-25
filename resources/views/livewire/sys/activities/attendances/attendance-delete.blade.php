<div>

    <x-modals.modal-dialog wire:model='open' includeFooter="0">
        <!-- modal title -->
        <x-slot:title>
            <div class="flex flex-row items-center">
                <h3 class="flex-grow font-bold text-lg uppercase text-purple-800 dark:text-purple-300 select-none">{{ __("messages.data.actions.delete", ['resource' => __('messages.models.event_attendance.model_name')]) }}</h3>
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

                    {{-- if attendance have id --}}
                    @if($attendance->id)

                        {{-- events data-card --}}
                        <x-sys.activities.attendances.data-card :attendance="$attendance"/>

                        {{-- confirm action message --}}
                        <x-utils.info-message class="mt-4">
                            {{-- title --}}
                            <x-slot:title class="uppercase">{{ __('messages.data.actions.confirm') }}</x-slot:title>
                            {{-- main_text --}}
                            <x-slot:main_text>{{ __('messages.data.actions.delete_question') }}</x-slot:main_text>
                            {{-- secondary_text --}}
                            <x-slot:secondary_text>{{ __('messages.data.actions.irreversible') }}</x-slot:secondary_text>
                        </x-utils.info-message>

                    @endif

                    {{-- action buttons --}}
                    <div class="w-full inline-flex space-x-2 items-center justify-end mt-5">
                        {{-- cancel button --}}
                        <x-buttons.secondary-button wire:click="$toggle('open')" type="button" color="violet">Cancelar</x-buttons.secondary-button>
                        {{-- save button --}}
                        <x-buttons.main-button wire:click="delete" wire:confirm.prompt="{{ __('messages.data.actions.confirm_delete') }}" type="button" color="red">Eliminar</x-buttons.main-button>
                    </div>

                </div>

            </form>
        </x-slot:content>

    </x-modals.modal-dialog>

</div>

