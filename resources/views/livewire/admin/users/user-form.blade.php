<div>

    <x-modals.modal-dialog wire:model='open' includeFooter="0">
        <!-- modal title -->
        <x-slot:title>
            <div class="flex flex-row items-center">
                <h3 class="flex-grow font-bold text-lg uppercase text-purple-800 dark:text-purple-300 select-none">{{ __("messages.data.actions.$action", ['resource' => __('messages.models.user.model_name')]) }}</h3>
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

                    {{-- if role have id (when action is edit) --}}
                    @if($user->id)
                        {{-- users data-card --}}
                        <x-admin.users.data-card :user="$user"/>
                    @endif

                    {{-- role form --}}
                    <x-cards.card title="Formulario de Usuario" :footer="0" color="stone-100">
                        <x-slot:content>
                            {{-- form-card --}}
                            <x-admin.users.form-card :user="$user" :action="$action" :profile_photo="$profile_photo">
                                {{-- if $profile_photo is not null --}}
                                @if($profile_photo)
                                    {{-- slot of temporary profile photo --}}
                                    <x-slot:profile_photo_slot>
                                        {{-- temporary selected profile photo --}}
                                        <img src="{{ $profile_photo->temporaryUrl() }}" class="w-48 rounded-lg shadow bg-zinc-100 bg-auto object-contain">
                                    </x-slot:profile_photo_slot>
                                @endif
                            </x-admin.users.form-card>
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
