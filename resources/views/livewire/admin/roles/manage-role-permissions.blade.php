<div>

    <x-modals.modal-dialog wire:model='open' includeFooter="0">
        <!-- modal title -->
        <x-slot:title>
            <div class="flex flex-row items-center">
                <h3 class="flex-grow font-bold text-lg uppercase text-purple-800 dark:text-purple-300 select-none">GESTIONAR PERMISOS DE ROL</h3>
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
                    @if($role->id)

                        {{-- role data-card --}}
                        <x-admin.roles.data-card :role="$role"/>

                        {{-- permissions --}}
                        <x-cards.card title="{{ __('messages.models.permission.plural_model_name') }}" footer="0" color="gray-100">

                            <x-slot:content>

                                <div class="flex flex-col items-start space-y-3">

                                    @foreach(\App\Models\Permission::get_permissions_by_module() as $item)

                                        <div class="flex flex-col space-y-4 p-3 bg-white dark:bg-slate-500 rounded-md shadow-sm hover:shadow-lg transition ease-in-out duration-300 w-full border-t-4 border-t-sky-300 dark:border-t-gray-800" x-data="{ open: false }">

                                            {{-- module name --}}
                                            <div class="flex flex-row items-center">
                                                {{-- title --}}
                                                {{--<label class="flex-grow inline-flex items-center space-x-2">
                                                    <x-forms.checkbox size="3"/>
                                                </label>--}}
                                                <span @click="open = !open" class="cursor-pointer flex-grow font-bold text-sm text-sky-600 dark:text-violet-200">{{ __($item['translate_key']) }}</span>
                                                {{-- action buttons --}}
                                                <div class="flex-shrink inline-flex items-center space-x-1">
                                                    {{-- exand more button --}}
                                                    <x-buttons.circle-icon-button color="amber" dark_gradient="300" x-show="!open" x-on:click="open = true" size="18px">expand_more</x-buttons.circle-icon-button>
                                                    {{-- exand less button --}}
                                                    <x-buttons.circle-icon-button color="amber" dark_gradient="300" x-show="open" x-on:click="open = false" size="18px">expand_less</x-buttons.circle-icon-button>
                                                </div>
                                            </div>

                                            {{-- if isset 'data' at item --}}
                                            @if(isset($item['data']))
                                                {{-- permissions of module --}}
                                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-x-4 gap-y-2" x-show="open">
                                                    @foreach($item['data'] as $permission)

                                                        {{-- permission --}}
                                                        <label class="flex-grow inline-flex items-center space-x-1">
                                                            {{-- checkbox --}}
                                                            <x-forms.checkbox wire:model="permissions" size="3" color="violet" value="{{ $permission['id'] }}"/>
                                                            {{-- label text --}}
                                                            <span class="font-medium text-xs text-gray-950 dark:text-gray-900">{{ __($permission['display_name']) }}</span>
                                                        </label>

                                                    @endforeach
                                                </div>
                                            @endif

                                        </div>

                                    @endforeach

                                </div>

                            </x-slot:content>

                        </x-cards.card>

                    @endif

                    {{-- action buttons --}}
                    <div class="w-full inline-flex space-x-2 items-center justify-end mt-5">
                        {{-- cancel button --}}
                        <x-buttons.secondary-button wire:click="$toggle('open')" type="button" color="red">Cancelar</x-buttons.secondary-button>
                        {{-- save button --}}
                        <x-buttons.main-button wire:click="save" wire:confirm="¿Esta segúro de guardar estos permisos al rol '{{ $role->display_name }}'?" type="button">Guardar</x-buttons.main-button>
                    </div>

                </div>

            </form>
        </x-slot:content>

    </x-modals.modal-dialog>

</div>
