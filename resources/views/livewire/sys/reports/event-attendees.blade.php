<div>

    {{-- sub header --}}
    <x-layouts.headers.sub-header title="{{ __('messages.models.event.reports.attendees-participation') }} - {{ $event->name }}" :actions="true">

        {{-- back --}}
        <a href="javascript:history.back()"> <x-buttons.circle-icon-button title="{{ __('messages.data.action.go_back') }}" color="yellow" size="20px">undo</x-buttons.circle-icon-button></a>

    </x-layouts.headers.sub-header>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 my-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Attendees</h3>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $total_attendees }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Billed</h3>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">${{ number_format($total_billed, 2) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Avg. Participation</h3>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($average_participation, 2) }}%</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Full Participation</h3>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $attendees_with_full_participation }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Can Be Certified</h3>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $certified_count }}</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mt-6">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Attendees Report</h2>

            <div class="flex items-center space-x-2">
                <div class="w-full">
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search attendees..." class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                </div>
                <button wire:click="export_report" class="px-4 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 9.707a1 1 0 011.414 0L9 11.086V3a1 1 0 112 0v8.086l1.293-1.379a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort_by('people.surnames')">
                            Name
                            @if ($sortBy === 'people.surnames')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort_by('people.nuip')">
                            NUIP
                            @if ($sortBy === 'people.nuip')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort_by('payment_status')">
                            Payment Status
                            @if ($sortBy === 'payment_status')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort_by('participation_modality')">
                            Participation Modality
                            @if ($sortBy === 'participation_modality')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort_by('institution_id')">
                            Institution
                            @if ($sortBy === 'institution_id')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort_by('type')">
                            Type
                            @if ($sortBy === 'type')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort_by('stay_type')">
                            Stay Type
                            @if ($sortBy === 'stay_type')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort_by('approve_certificate_manually')">
                            Manual Cert. Approval
                            @if ($sortBy === 'approve_certificate_manually')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort_by('attended_activities_count')">
                            Attended Activities
                            @if ($sortBy === 'attended_activities_count')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort_by('attended_activities_count')">
                            Participation
                            @if ($sortBy === 'attended_activities_count')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort_by('certificate')">
                            Certificate
                            @if ($sortBy === 'certificate')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendees as $attendee)
                        @php
                            $percentage = $total_activities > 0 ? ($attendee->attended_activities_count / $total_activities) * 100 : 0;
                            $can_be_certified = $attendee->can_get_certificate();
                        @endphp
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $attendee->person->getFullName() }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $attendee->person->nuip }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $attendee->get_payment_status('color') }}-100 text-{{ $attendee->get_payment_status('color') }}-800">
                                    {{ __($attendee->get_payment_status('key_name')) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $attendee->get_participation_modality('color') }}-100 text-{{ $attendee->get_participation_modality('color') }}-800">
                                    {{ __($attendee->get_participation_modality('key_name')) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                {{ $attendee->get_institution() }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $attendee->get_type() }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $attendee->get_stay_type() }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $attendee->get_approve_certificate_manually_status('color') }}-100 text-{{ $attendee->get_approve_certificate_manually_status('color') }}-800">
                                    {{ __($attendee->get_approve_certificate_manually_status('key_name')) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                {{ $attendee->attended_activities_count }} of {{ $total_activities }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mr-2">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span class="text-xs font-medium">{{ number_format($percentage, 0) }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($can_be_certified)
                                    <a href="{{ route('portal.home') }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                        View Certificate
                                    </a>
                                @else
                                    <span class="text-red-500">Not available</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-6 py-4 text-center">No attendees found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $attendees->links() }}
        </div>

    </div>
</div> 