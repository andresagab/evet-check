<div>
    <x-modals.modal-dialog wire:model="open" max-width="6xl">

        {{-- title --}}
        <x-slot name="title">
            <div class="flex flex-row items-center space-x-2">
                <x-utils.icon class="text-gray-700 dark:text-white">upload_file</x-utils.icon>
                <span class="font-bold text-gray-700 dark:text-white">
                    Importación masiva de participantes
                </span>
                <x-loaders.section-loader wire:loading wire:target="import" />
            </div>
        </x-slot>

        {{-- content --}}
        <x-slot name="content">

            {{-- if results is empty --}}
            @if(empty($results))
                <form wire:submit.prevent="import" id="import-form">
                    <div class="flex flex-col space-y-6 p-4">
                        {{-- file --}}
                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Seleccionar archivo (.csv, .json)</label>
                            <input wire:model="file" type="file" id="file" class="mt-2 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                            @error('file') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- info --}}
                        <div class="p-4 text-sm text-sky-800 rounded-lg bg-sky-50 dark:bg-gray-800 dark:text-sky-400" role="alert">
                            <div class="flex items-center">
                                <x-utils.icon class="mr-2">info</x-utils.icon>
                                <span class="font-bold text-lg">Información importante</span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Se importarán los datos del archivo y se crearán los registros de asistencia de los participantes. Si la persona ya existe solo se creará el registro de asistencia, en caso contrario se creará la persona y el registro de asistencia. El registro de asistencia no se creará si la persona ya tiene un registro de asistencia para este evento.
                            </p>
                            <ul class="mt-3 list-disc list-inside space-y-1">
                                <li>El archivo debe ser de tipo .csv o .json.</li>
                                <li>La primera fila del archivo .csv debe contener los encabezados.</li>
                                <li>El archivo debe contener las siguientes columnas/claves: <br> <code class="text-xs font-mono bg-gray-200 dark:bg-gray-700 p-1 rounded">nuip, names, surnames, cel, phone, email, institution_name, other_institution, participation_modality, type, stay_type, payment_status</code></li>
                                <li>Si un registro no tiene un valor para el tipo de asistente, se asumirá el valor <code class="text-xs font-mono bg-gray-200 dark:bg-gray-700 p-1 rounded">{{ __('messages.models.event_attendance.types.ND') }}</code></li>
                                <li>Si un registro no tiene un valor para el tipo de asistencia, se asumirá el valor <code class="text-xs font-mono bg-gray-200 dark:bg-gray-700 p-1 rounded">{{ __('messages.models.event_attendance.stay_types.P') }}</code></li>
                                <li>Si un registro no tiene un valor para el tipo de pago, se asumirá el valor <code class="text-xs font-mono bg-gray-200 dark:bg-gray-700 p-1 rounded">{{ __('messages.models.event_attendance.payment_statuses.NP') }}</code></li>
                            </ul>
                        </div>

                    </div>
                </form>
            @else
                {{-- results --}}
                <div class="flex flex-col space-y-6 p-4">
                    {{-- summary --}}
                    <div class="p-4 border rounded-lg bg-gray-50 dark:bg-gray-800/50 dark:border-gray-700">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-2">Resumen de la importación</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                            <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Registros leídos</p>
                                <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $results['read_records'] }}</p>
                            </div>
                            <div class="p-4 bg-green-100 dark:bg-green-800/50 rounded-lg">
                                <p class="text-sm text-green-600 dark:text-green-400">Registros guardados</p>
                                <p class="text-2xl font-bold text-green-700 dark:text-green-300">{{ $results['saved_records'] }}</p>
                            </div>
                            <div class="p-4 bg-red-100 dark:bg-red-800/50 rounded-lg">
                                <p class="text-sm text-red-600 dark:text-red-400">Registros fallidos</p>
                                <p class="text-2xl font-bold text-red-700 dark:text-red-300">{{ $results['failed_records_count'] }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- failed records --}}
                    @if($results['failed_records_count'] > 0)
                        <div class="flex flex-col space-y-4">
                            <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-200">Detalle de registros fallidos</h4>

                            {{-- Search input --}}
                            <div class="w-full md:w-1/3">
                                <label for="search_failed_records" class="sr-only">Buscar registros fallidos</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <x-utils.icon class="text-gray-400">search</x-utils.icon>
                                    </div>
                                    <input wire:model.live.debounce.300ms="search_failed_records" type="text" id="search_failed_records" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Buscar...">
                                </div>
                            </div>

                            <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-slate-800">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fila</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Datos</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Errores</th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-slate-700 dark:divide-slate-600">
                                    @forelse($failed_records_list as $record)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-600">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">{{ $record['row'] }}</td>
                                            <td class="px-6 py-4 whitespace-normal text-sm text-gray-500 dark:text-gray-300"><code class="text-xs bg-gray-100 dark:bg-gray-800 p-1 rounded-md block">{{ json_encode($record['data'], JSON_PRETTY_PRINT) }}</code></td>
                                            <td class="px-6 py-4 whitespace-normal text-sm text-red-600 dark:text-red-400">
                                                <ul class="list-disc list-inside space-y-1">
                                                    @foreach($record['errors'] as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                                No se encontraron registros que coincidan con la búsqueda.
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                </div>
            @endif

        </x-slot>

        {{-- footer --}}
        <x-slot name="footer">
            <div class="flex justify-end items-center space-x-2">
                {{-- if results is empty --}}
                @if(empty($results))
                    <button type="submit" form="import-form" wire:loading.attr="disabled" wire:target="import" class="inline-flex items-center justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 disabled:opacity-50">
                        <x-utils.icon class="mr-2" size="16px">upload_file</x-utils.icon>
                        Importar
                    </button>
                @else
                    <x-buttons.secondary-button wire:click="$set('results', [])">
                        Importar otro archivo
                    </x-buttons.secondary-button>
                @endif
                <x-buttons.secondary-button wire:click="closeModal">
                    Cerrar
                </x-buttons.secondary-button>
            </div>
        </x-slot>

    </x-modals.modal-dialog>
</div> 