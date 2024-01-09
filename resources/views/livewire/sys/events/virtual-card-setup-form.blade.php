<div>

    <x-modals.modal-dialog wire:model='open' includeFooter="0">
        <!-- modal title -->
        <x-slot:title>
            <div class="flex flex-row items-center">
                <h3 class="flex-grow font-bold text-lg uppercase text-purple-800 dark:text-purple-300 select-none">{{ __("messages.models.event.virtual_card_form") }}</h3>
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

                    {{-- if event have id (when action is edit) --}}
                    @if($event->id)
                        {{-- event data-card --}}
                        <x-sys.events.data-card :event="$event"/>
                    @endif

                    {{-- person form --}}
                    <x-cards.card title="Formulario de configuración" :footer="0" color="stone-100">
                        <x-slot:content>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-baseline w-full">

                                {{-- desing section --}}
                                <hr class="col-span-full">

                                {{-- title section --}}
                                <h3 class="font-semibold text-sm text-white col-span-full">Datos del asistente</h3>

                                {{-- person_names_margin_top --}}
                                <x-forms.input-group class="w-full col-span-1">
                                    {{-- label --}}
                                    <x-forms.label value="{{ __('messages.models.person.names_surnames') }} (Margen superior):" for="frm.person_names_margin_top" class="required"/>
                                    {{-- input --}}
                                    <x-forms.input type="number" wire:model="frm.person_names_margin_top" required min="0.1" max="1" step="0.1" placeholder="Ingresa el margen superior en pixeles"/>
                                    {{-- error --}}
                                    <x-forms.error for="frm.person_names_margin_top"/>
                                </x-forms.input-group>

                                {{-- person_names_margin_x --}}
                                <x-forms.input-group class="w-full col-span-1">
                                    {{-- label --}}
                                    <x-forms.label value="{{ __('messages.models.person.names_surnames') }} (Margen izquierdo y derecho):" for="frm.person_names_margin_x" class="required"/>
                                    {{-- input --}}
                                    <x-forms.input type="number" wire:model="frm.person_names_margin_x" required min="0.1" max="1" step="0.1" placeholder="Ingresa el margen izquierdo y derecho en pixeles"/>
                                    {{-- error --}}
                                    <x-forms.error for="frm.person_names_margin_x"/>
                                </x-forms.input-group>

                                {{-- dni_margin_top --}}
                                <x-forms.input-group class="w-full col-span-1">
                                    {{-- label --}}
                                    <x-forms.label value="{{ __('messages.models.person.nip') }} (Margen superior):" for="frm.dni_margin_top" class="required"/>
                                    {{-- input --}}
                                    <x-forms.input type="number" wire:model="frm.dni_margin_top" required min="0.1" max="1" step="0.1" placeholder="Ingresa el margen superior en pixeles"/>
                                    {{-- error --}}
                                    <x-forms.error for="frm.dni_margin_top"/>
                                </x-forms.input-group>

                                {{-- dni_margin_x --}}
                                <x-forms.input-group class="w-full col-span-1">
                                    {{-- label --}}
                                    <x-forms.label value="{{ __('messages.models.person.nip') }} (Margen izquierdo y derecho):" for="frm.dni_margin_x" class="required"/>
                                    {{-- input --}}
                                    <x-forms.input type="number" wire:model="frm.dni_margin_x" required min="0.1" max="1" step="0.1" placeholder="Ingresa el margen izquierdo y derecho en pixeles"/>
                                    {{-- error --}}
                                    <x-forms.error for="frm.dni_margin_x"/>
                                </x-forms.input-group>

                                {{-- attendance_type_margin_top --}}
                                <x-forms.input-group class="w-full col-span-1">
                                    {{-- label --}}
                                    <x-forms.label value="{{ __('messages.models.event_attendance.participation_modality') }} (Margen superior):" for="frm.attendance_type_margin_top" class="required"/>
                                    {{-- input --}}
                                    <x-forms.input type="number" wire:model="frm.attendance_type_margin_top" required min="0.1" max="1" step="0.1" placeholder="Ingresa el margen superior en pixeles"/>
                                    {{-- error --}}
                                    <x-forms.error for="frm.attendance_type_margin_top"/>
                                </x-forms.input-group>

                                {{-- attendance_type_margin_x --}}
                                <x-forms.input-group class="w-full col-span-1">
                                    {{-- label --}}
                                    <x-forms.label value="{{ __('messages.models.event_attendance.participation_modality') }} (Margen izquierdo y derecho):" for="frm.attendance_type_margin_x" class="required"/>
                                    {{-- input --}}
                                    <x-forms.input type="number" wire:model="frm.attendance_type_margin_x" required min="0.1" max="1" step="0.1" placeholder="Ingresa el margen izquierdo y derecho en pixeles"/>
                                    {{-- error --}}
                                    <x-forms.error for="frm.attendance_type_margin_x"/>
                                </x-forms.input-group>

                                {{-- bar code section --}}
                                <hr class="col-span-full">

                                {{-- title section --}}
                                <h3 class="font-semibold text-sm text-white col-span-full">Código de barras</h3>

                                {{-- bar_code_position --}}
                                <x-forms.input-group class="w-full col-span-1">
                                    {{-- label --}}
                                    <x-forms.label value="Código de barras (Posicionamiento):" for="frm.bar_code_position" class="required"/>
                                    {{-- input --}}
                                    <x-forms.select wire:model="frm.bar_code_position" required>
                                        @foreach(\App\Models\Sys\Event::BAR_CODE_POSITIONS as $key => $item)
                                            <option value="{{ $key }}">{{ __($item) }}</option>
                                        @endforeach
                                    </x-forms.select>
                                    {{-- error --}}
                                    <x-forms.error for="frm.bar_code_position"/>
                                </x-forms.input-group>

                                {{-- bar_code_margin_top --}}
                                <x-forms.input-group class="w-full col-span-1">
                                    {{-- label --}}
                                    <x-forms.label value="Código de barras (Margen superior):" for="frm.bar_code_margin_top"/>
                                    {{-- input --}}
                                    <x-forms.input type="number" wire:model="frm.bar_code_margin_top" min="0.1" max="1" step="0.1" placeholder="Ingresa el margen superior en pixeles"/>
                                    {{-- error --}}
                                    <x-forms.error for="frm.bar_code_margin_top"/>
                                </x-forms.input-group>

                                {{-- bar_code_margin_bottom --}}
                                <x-forms.input-group class="w-full col-span-1">
                                    {{-- label --}}
                                    <x-forms.label value="Código de barras (Margen inferior):" for="frm.bar_code_margin_bottom"/>
                                    {{-- input --}}
                                    <x-forms.input type="number" wire:model="frm.bar_code_margin_bottom" min="0.1" max="1" step="0.1" placeholder="Ingresa el margen inferior en pixeles"/>
                                    {{-- error --}}
                                    <x-forms.error for="frm.bar_code_margin_bottom"/>
                                </x-forms.input-group>

                                {{-- bar_code_margin_left --}}
                                <x-forms.input-group class="w-full col-span-1">
                                    {{-- label --}}
                                    <x-forms.label value="Código de barras (Margen izquierdo):" for="frm.bar_code_margin_left"/>
                                    {{-- input --}}
                                    <x-forms.input type="number" wire:model="frm.bar_code_margin_left" min="0.1" max="1" step="0.1" placeholder="Ingresa el margen izquierdo en pixeles"/>
                                    {{-- error --}}
                                    <x-forms.error for="frm.bar_code_margin_left"/>
                                </x-forms.input-group>

                                {{-- bar_code_margin_right --}}
                                <x-forms.input-group class="w-full col-span-1">
                                    {{-- label --}}
                                    <x-forms.label value="Código de barras (Margen derecho):" for="frm.bar_code_margin_right"/>
                                    {{-- input --}}
                                    <x-forms.input type="number" wire:model="frm.bar_code_margin_right" min="0.1" max="1" step="0.1" placeholder="Ingresa el margen derecho en pixeles"/>
                                    {{-- error --}}
                                    <x-forms.error for="frm.bar_code_margin_right"/>
                                </x-forms.input-group>

                                {{-- text and others section --}}
                                <hr class="col-span-full">

                                {{-- title section --}}
                                <h3 class="font-semibold text-sm text-white col-span-full">Texto y otros</h3>

                                {{-- font_size --}}
                                <x-forms.input-group class="w-full">
                                    {{-- label --}}
                                    <x-forms.label value="Tamaño del texto:" for="frm.font_size" class="required"/>
                                    {{-- input --}}
                                    <x-forms.input type="number" wire:model="frm.font_size" required min="1" placeholder="Ingresa el tamaño del texto en pixeles"/>
                                    {{-- error --}}
                                    <x-forms.error for="frm.font_size"/>
                                </x-forms.input-group>

                                {{-- text_color --}}
                                <x-forms.input-group class="w-full">
                                    {{-- label --}}
                                    <x-forms.label value="Color del texto (Nombres y N° identificación):" for="frm.text_color" class="required"/>
                                    {{-- input --}}
                                    <x-forms.input type="color" wire:model="frm.text_color" required placeholder="Selecciona el color del texto del certificado"/>
                                    {{-- error --}}
                                    <x-forms.error for="frm.text_color"/>
                                </x-forms.input-group>

                                {{-- attendance_type_text_color --}}
                                <x-forms.input-group class="w-full">
                                    {{-- label --}}
                                    <x-forms.label value="Color del texto ({{ __('messages.models.event_attendance.participation_modality') }}):" for="frm.attendance_type_text_color" class="required"/>
                                    {{-- input --}}
                                    <x-forms.input type="color" wire:model="frm.attendance_type_text_color" required placeholder="Selecciona el color del texto del certificado"/>
                                    {{-- error --}}
                                    <x-forms.error for="frm.attendance_type_text_color"/>
                                </x-forms.input-group>

                                {{-- background_opacity --}}
                                <x-forms.input-group class="w-full col-span-full">
                                    {{-- label --}}
                                    <x-forms.label value="Opacidad de la plantilla de fondo:" for="frm.background_opacity" class="required"/>
                                    {{-- input --}}
                                    <x-forms.input type="number" wire:model="frm.background_opacity" required min="0.1" max="1" step="0.1" placeholder="Ingresa el nivel de opacidad para la plantilla de fondo (valor de 0.1 a 1)"/>
                                    {{-- error --}}
                                    <x-forms.error for="frm.background_opacity"/>
                                </x-forms.input-group>

                            </div>

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
