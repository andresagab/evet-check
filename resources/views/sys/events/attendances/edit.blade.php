<x-layouts.pages.sys-layout :title="__('messages.data.actions.edit', ['resource' => __('messages.models.event_attendance.model_name')])">

    <x-layouts.headers.sub-header :title="__('messages.data.actions.edit', ['resource' => __('messages.models.event_attendance.model_name')]) . ' - ' . $attendance->person->getFullName()" />

    <x-layouts.pages.content.base-content-page-layout>

        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 sm:p-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                {{ __('messages.data.actions.edit', ['resource' => __('messages.models.event_attendance.model_name')]) }}
            </h2>
            <form action="{{ route('sys.events.attendances.update', ['event' => $event, 'attendance' => $attendance]) }}" method="POST" autocomplete="off" novalidate>
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- event name --}}
                    <div class="inline-flex items-center space-x-1 px-1.5 col-span-full">
                        <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.event_attendance.event') }}:</span>
                        <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $event->name }} ({{ $event->year }})</span>
                    </div>

                    {{-- person_id --}}
                    <div class="col-span-full" x-data x-init="new TomSelect($refs.select_person, { create: false, sortField: { field: 'text', direction: 'asc' } });">
                        <label for="person_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.models.event_attendance.person') }}</label>
                        <select id="person_id" name="person_id" x-ref="select_person" required>
                            @foreach($people as $person)
                                <option value="{{ $person->id }}" {{ old('person_id', $attendance->person_id) == $person->id ? 'selected' : '' }}>{{ $person->getFullName() }}</option>
                            @endforeach
                        </select>
                        <x-forms.error for="person_id"/>
                    </div>

                    {{-- institution_id --}}
                    <div>
                        <label for="institution_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.models.event_attendance.institution') }}</label>
                        <select id="institution_id" name="institution_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                            @foreach($institutions as $key => $value)
                                <option value="{{ $key }}" {{ old('institution_id', $attendance->institution_id) == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        <x-forms.error for="institution_id"/>
                    </div>

                    {{-- other_institution --}}
                    <div>
                        <label for="other_institution" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.models.event_attendance.other_institution') }}</label>
                        <input type="text" id="other_institution" name="other_institution" value="{{ old('other_institution', $attendance->other_institution) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Ingresa el nombre de la Institución">
                        <x-forms.error for="other_institution"/>
                    </div>

                    {{-- participation_modality --}}
                    <div>
                        <label for="participation_modality" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.models.event_attendance.participation_modality') }}</label>
                        <select id="participation_modality" name="participation_modality" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                            @foreach($participation_modalities as $item)
                                <option value="{{ $item['key'] }}" {{ old('participation_modality', $attendance->participation_modality) == $item['key'] ? 'selected' : '' }}>{{ __($item['key_name']) }}</option>
                            @endforeach
                        </select>
                        <x-forms.error for="participation_modality"/>
                    </div>

                    {{-- type --}}
                    <div>
                        <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.models.event_attendance.type') }}</label>
                        <select id="type" name="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                            @foreach($types as $key => $value)
                                <option value="{{ $key }}" {{ old('type', $attendance->type) == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        <x-forms.error for="type"/>
                    </div>

                    {{-- stay_type --}}
                    <div>
                        <label for="stay_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.models.event_attendance.stay_type') }}</label>
                        <select id="stay_type" name="stay_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                             @foreach($stay_types as $key => $value)
                                <option value="{{ $key }}" {{ old('stay_type', $attendance->stay_type) == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        <x-forms.error for="stay_type"/>
                    </div>

                    {{-- payment_status --}}
                    @ability('*', 'event_attendances:set_as_paid')
                    <div>
                        <label for="payment_status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.models.event_attendance.payment_status') }}</label>
                        <select id="payment_status" name="payment_status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                            @foreach($payment_statuses as $item)
                                <option value="{{ $item['key'] }}" {{ old('payment_status', $attendance->payment_status) == $item['key'] ? 'selected' : '' }}>{{ __($item['key_name']) }}</option>
                            @endforeach
                        </select>
                        <x-forms.error for="payment_status"/>
                    </div>
                    @endability

                    {{-- approve_certificate_manually --}}
                    @ability('*', 'event_attendances:set_approve_certificate_manually')
                    <div>
                        <label for="approve_certificate_manually" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.models.event_attendance.approve_certificate_manually') }}</label>
                        <select id="approve_certificate_manually" name="approve_certificate_manually" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                           @foreach($affirmations as $key => $value)
                                <option value="{{ $key }}" {{ old('approve_certificate_manually', $attendance->approve_certificate_manually) == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        <x-forms.error for="approve_certificate_manually"/>
                    </div>
                    @endability

                </div>

                {{-- action buttons --}}
                <div class="w-full flex justify-end items-center space-x-4 mt-6">
                    <a href="{{ route('sys.events.attendances', $event) }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">Cancelar</a>
                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Actualizar</button>
                </div>
            </form>
        </div>

    </x-layouts.pages.content.base-content-page-layout>
</x-layouts.pages.sys-layout> 