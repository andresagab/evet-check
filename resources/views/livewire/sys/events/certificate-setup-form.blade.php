<div>

    <x-modals.modal-dialog wire:model='open' includeFooter="0">
        <!-- modal title -->
        <x-slot:title>
            <div class="flex flex-row items-center">
                <h3 class="flex-grow font-bold text-lg uppercase text-purple-800 dark:text-purple-300 select-none">{{ __("messages.models.event.certificate_form") }}</h3>
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
                                {{-- head_text --}}
                                <x-forms.input-group class="w-full col-span-full">
                                    {{-- label --}}
                                    <x-forms.label value="Texto del encabezado:" for="frm.head_text" class="required"/>
                                    {{-- input --}}
                                    <x-forms.text-area wire:model="frm.head_text" required maxLength="1000" rows="3" placeholder="Ingresa el texto que aparecerá en el encabezado del certificado"/>
                                    {{-- error --}}
                                    <x-forms.error for="frm.head_text"/>
                                </x-forms.input-group>

                                {{-- dates_range --}}
                                <x-forms.input-group class="w-full col-span-full">
                                    {{-- label --}}
                                    <x-forms.label value="Rango de fechas:" for="frm.dates_range" class="required"/>
                                    {{-- input --}}
                                    <x-forms.text-area wire:model="frm.dates_range" required maxLength="1000" rows="3" placeholder="Ingresa el texto correspondiente al rango de fechas en las que se llevó a cabo el evento, ejemplo: los días 30 de noviembre y 1 de diciembre del 2023"/>
                                    {{-- error --}}
                                    <x-forms.error for="frm.dates_range"/>
                                </x-forms.input-group>

                                {{-- desing section --}}
                                <hr class="col-span-full">

                                {{-- title section --}}
                                <h3 class="font-semibold text-sm text-white">Diseño</h3>

                                {{-- background_opacity --}}
                                <x-forms.input-group class="w-full col-span-full">
                                    {{-- label --}}
                                    <x-forms.label value="Opacidad de la plantilla de fondo:" for="frm.background_opacity" class="required"/>
                                    {{-- input --}}
                                    <x-forms.input type="number" wire:model="frm.background_opacity" required min="0.1" max="1" step="0.1" placeholder="Ingresa el nivel de opacidad para la plantilla de fondo (valor de 0.1 a 1)"/>
                                    {{-- error --}}
                                    <x-forms.error for="frm.background_opacity"/>
                                </x-forms.input-group>

                                {{-- margin_top --}}
                                <x-forms.input-group class="w-full">
                                    {{-- label --}}
                                    <x-forms.label value="Margen superior del texto:" for="frm.margin_top" class="required"/>
                                    {{-- input --}}
                                    <x-forms.input type="number" wire:model="frm.margin_top" required min="1" placeholder="Ingresa el margen superior en pixeles"/>
                                    {{-- error --}}
                                    <x-forms.error for="frm.margin_top"/>
                                </x-forms.input-group>

                                {{-- margin_left_right --}}
                                <x-forms.input-group class="w-full">
                                    {{-- label --}}
                                    <x-forms.label value="Margen izquierdo y derecho del texto:" for="frm.margin_left_right" class="required"/>
                                    {{-- input --}}
                                    <x-forms.input type="number" wire:model="frm.margin_left_right" required min="1" placeholder="Ingresa el margen izquierdo y derecho en pixeles"/>
                                    {{-- error --}}
                                    <x-forms.error for="frm.margin_left_right"/>
                                </x-forms.input-group>

                                {{-- margin_top_middle_text --}}
                                <x-forms.input-group class="w-full">
                                    {{-- label --}}
                                    <x-forms.label value="Margen superior del texto central (persona certificada):" for="frm.margin_top_middle_text" class="required"/>
                                    {{-- input --}}
                                    <x-forms.input type="number" wire:model="frm.margin_top_middle_text" required min="1" placeholder="Ingresa el margen superior del texto central en pixeles"/>
                                    {{-- error --}}
                                    <x-forms.error for="frm.margin_top_middle_text"/>
                                </x-forms.input-group>

                                {{-- margin_bottom_middle_text --}}
                                <x-forms.input-group class="w-full">
                                    {{-- label --}}
                                    <x-forms.label value="Margen inferior del texto central (persona certificada):" for="frm.margin_bottom_middle_text" class="required"/>
                                    {{-- input --}}
                                    <x-forms.input type="number" wire:model="frm.margin_bottom_middle_text" required min="1" placeholder="Ingresa el margen inferior del texto central en pixeles"/>
                                    {{-- error --}}
                                    <x-forms.error for="frm.margin_bottom_middle_text"/>
                                </x-forms.input-group>

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
                                    <x-forms.label value="Color del texto:" for="frm.text_color" class="required"/>
                                    {{-- input --}}
                                    <x-forms.input type="color" wire:model="frm.text_color" required placeholder="Selecciona el color del texto del certificado"/>
                                    {{-- error --}}
                                    <x-forms.error for="frm.text_color"/>
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
