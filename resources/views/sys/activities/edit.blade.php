<x-layouts.pages.sys-layout :title="__('messages.data.actions.edit', ['resource' => __('messages.models.activity.model_name')])">

    <x-layouts.headers.sub-header :title="__('messages.data.actions.edit', ['resource' => __('messages.models.activity.model_name')])" />

    <x-layouts.pages.content.base-content-page-layout>

        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 sm:p-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                {{ __('messages.data.actions.edit', ['resource' => __('messages.models.activity.model_name')]) }}
            </h2>

            <form action="{{ route('sys.activities.update', $activity) }}" method="POST" autocomplete="off" novalidate>
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- event_id --}}
                    <div class="col-span-full">
                        <label for="event_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.models.activity.event') }}</label>
                        <select id="event_id" name="event_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}" {{ $activity->event_id == $event->id ? 'selected' : '' }}>{{ $event->name }}</option>
                            @endforeach
                        </select>
                        <x-forms.error for="event_id"/>
                    </div>

                    {{-- name --}}
                    <div class="col-span-full">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.models.activity.name') }}</label>
                        <textarea id="name" name="name" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Ingresa el nombre de la actividad" required>{{ old('name', $activity->name) }}</textarea>
                        <x-forms.error for="name"/>
                    </div>

                    {{-- author_name --}}
                    <div class="col-span-full">
                        <label for="author_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.models.activity.author_name') }}</label>
                        <textarea id="author_name" name="author_name" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Ingresa el nombre del autor o autores de la actividad" required>{{ old('author_name', $activity->author_name) }}</textarea>
                        <x-forms.error for="author_name"/>
                    </div>

                    {{-- slots --}}
                    <div>
                        <label for="slots" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.models.activity.slots') }}</label>
                        <input type="number" id="slots" name="slots" min="0" max="99999" value="{{ old('slots', $activity->slots) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Ingresa la cantidad de cupos" required>
                        <x-forms.error for="slots"/>
                    </div>

                    {{-- type --}}
                    <div>
                        <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.models.activity.type') }}</label>
                        <select id="type" name="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                           @foreach($types as $key => $value)
                                <option value="{{ $key }}" {{ old('type', $activity->type) == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        <x-forms.error for="type"/>
                    </div>

                    {{-- modality --}}
                    <div>
                        <label for="modality" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.models.activity.modality') }}</label>
                        <select id="modality" name="modality" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                            @foreach($modalities as $key => $value)
                                <option value="{{ $key }}" {{ old('modality', $activity->modality) == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        <x-forms.error for="modality"/>
                    </div>

                    {{-- status --}}
                    <div>
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.models.activity.status') }}</label>
                        <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                             @foreach($statuses as $key => $value)
                                <option value="{{ $key }}" {{ old('status', $activity->status) == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        <x-forms.error for="status"/>
                    </div>

                    {{-- hide --}}
                    <div>
                        <label for="hide" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.models.activity.hidden') }}</label>
                        <select id="hide" name="hide" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                            <option value="1" {{ old('hide', $activity->hide) == 1 ? 'selected' : '' }}>Si</option>
                            <option value="0" {{ old('hide', $activity->hide) == 0 ? 'selected' : '' }}>No</option>
                        </select>
                        <x-forms.error for="hide"/>
                    </div>

                    {{-- location_id --}}
                    <div class="col-span-full">
                        <label for="location_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.models.activity.location') }}</label>
                        <select id="location_id" name="location_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ $activity->location_id == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                            @endforeach
                        </select>
                        <x-forms.error for="location_id"/>
                    </div>

                    {{-- date --}}
                    <div class="col-span-full">
                        <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.models.activity.date') }}</label>
                        <input type="datetime-local" id="date" name="date" value="{{ old('date', $activity->date) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                        <x-forms.error for="date"/>
                    </div>
                </div>

                {{-- action buttons --}}
                <div class="w-full flex justify-end items-center space-x-4 mt-6">
                    <a href="{{ route('sys.activities') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">Cancelar</a>
                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Actualizar</button>
                </div>
            </form>
        </div>

    </x-layouts.pages.content.base-content-page-layout>
</x-layouts.pages.sys-layout> 