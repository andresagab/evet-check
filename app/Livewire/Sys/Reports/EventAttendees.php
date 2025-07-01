<?php

namespace App\Livewire\Sys\Reports;

use App\Models\Sys\ActivityAttendance;
use App\Models\Sys\Event;
use App\Models\Sys\EventAttendance;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\Component;
use Livewire\WithPagination;

class EventAttendees extends Component
{
    use WithPagination;

    public Event $event;

    public string $search = '';

    public string $sortBy = 'people.surnames';

    public string $sortDirection = 'asc';

    /**
     * @param Event $event
     * @return void
     */
    public function mount(Event $event): void
    {
        $this->event = $event;
    }

    /**
     * @param $field
     * @return void
     */
    public function sort_by($field): void
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortBy = $field;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export_report()
    {
        $attendees = $this->get_attendees_query()->get();
        $total_activities = $this->event->activities()->where('hide', 0)->count();

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=event-attendees-report.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($attendees, $total_activities) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'ID',
                'Name',
                'Surnames',
                'NUIP',
                'Payment Status',
                'Attended Activities',
                'Participation Percentage',
                'Can be Certified',
                'Participation Modality',
                'Institution',
                'Type',
                'Stay Type',
                'Certificate Approved Manually',
            ]);

            foreach ($attendees as $attendee) {
                $percentage = $total_activities > 0 ? ($attendee->attended_activities_count / $total_activities) * 100 : 0;
                fputcsv($handle, [
                    $attendee->id,
                    $attendee->person->names,
                    $attendee->person->surnames,
                    $attendee->person->nuip,
                    __($attendee->get_payment_status('key_name')),
                    $attendee->attended_activities_count,
                    number_format($percentage, 2) . '%',
                    $attendee->can_get_certificate() ? 'Yes' : 'No',
                    __($attendee->get_participation_modality('key_name')),
                    $attendee->get_institution(),
                    $attendee->get_type(),
                    $attendee->get_stay_type(),
                    __($attendee->get_approve_certificate_manually_status('key_name')),
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function get_attendees_query()
    {
        return EventAttendance::query()
            ->with('person')
            ->join('people', 'event_attendances.person_id', '=', 'people.id')
            ->where('event_attendances.event_id', $this->event->id)
            ->select('event_attendances.*', 'people.names', 'people.surnames', 'people.nuip')
            ->addSelect([
                'attended_activities_count' => ActivityAttendance::query()
                    ->join('activities', 'activity_attendances.activity_id', '=', 'activities.id')
                    ->whereColumn('activity_attendances.person_id', 'event_attendances.person_id')
                    ->where('activities.event_id', $this->event->id)
                    ->where('activity_attendances.state', 'DO')
                    ->where('activities.hide', 0)
                    ->selectRaw('count(*)'),
            ])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('people.names', 'like', '%' . $this->search . '%')
                        ->orWhere('people.surnames', 'like', '%' . $this->search . '%')
                        ->orWhere('people.nuip', 'like', '%' . $this->search . '%');
                });
            });
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {

        $total_activities = $this->event->activities()->where('hide', 0)->count();

        $query = $this->get_attendees_query();

        $dbSortable = [
            'people.surnames', 'people.nuip', 'payment_status',
            'participation_modality', 'institution_id',
            'type', 'stay_type', 'approve_certificate_manually',
            'attended_activities_count'
        ];

        if (in_array($this->sortBy, $dbSortable)) {
            if ($this->sortBy === 'institution_id') {
                $query->orderBy('event_attendances.institution_id', $this->sortDirection)
                    ->orderBy('event_attendances.other_institution', $this->sortDirection);
            } else {
                $sortColumn = $this->sortBy;
                if (!str_contains($sortColumn, '.') && $sortColumn !== 'attended_activities_count') {
                    $sortColumn = 'event_attendances.' . $sortColumn;
                }
                $query->orderBy($sortColumn, $this->sortDirection);
            }
        } else {
            // Default sort
            $query->orderBy('people.surnames', 'asc');
        }

        $all_attendees = $query->get();

        if ($this->sortBy === 'certificate') {
            $all_attendees = $all_attendees->sortBy(
                fn($attendee) => $attendee->can_get_certificate(),
                SORT_REGULAR,
                $this->sortDirection === 'desc'
            );
        }

        $total_attendees = $all_attendees->count();
        $total_attended_activities_sum = $all_attendees->sum('attended_activities_count');
        $average_participation = ($total_attendees > 0 && $total_activities > 0) ?
            ($total_attended_activities_sum / $total_attendees / $total_activities) * 100 : 0;
        $attendees_with_full_participation = $total_activities > 0 ? $all_attendees->where('attended_activities_count', $total_activities)->count() : 0;

        $min_percent_for_certificate = $this->event->min_percent ?? 0;
        $min_attendance_for_certificate = floor(($min_percent_for_certificate / 100) * $total_activities);
        $certified_count = $all_attendees->filter(function ($attendee) use ($min_attendance_for_certificate) {
            if ($attendee->participation_modality != 'AS' && $attendee->payment_status === 'PA')
                return true;
            if ($attendee->approve_certificate_manually)
                return true;
            if ($attendee->payment_status === 'PA' && $attendee->participation_modality === 'AS')
                return $attendee->attended_activities_count >= $min_attendance_for_certificate;
            return false;
        })->count();

        $paid_attendees_count = $all_attendees->where('payment_status', 'PA')->count();
        $total_billed = $paid_attendees_count * ($this->event->symbolic_cost ?? 0);

        $page = Paginator::resolveCurrentPage('page');
        $perPage = 15;
        $attendees = new LengthAwarePaginator(
            $all_attendees->forPage($page, $perPage),
            $all_attendees->count(),
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath(), 'pageName' => 'page']
        );

        return view('livewire.sys.reports.event-attendees', compact(
            'attendees',
            'total_activities',
            'total_attendees',
            'average_participation',
            'attendees_with_full_participation',
            'certified_count',
            'total_billed',
        ))->layout('components.layouts.pages.sys-layout', [
            'title' => __('messages.menu.reports') . ' - ' . $this->event->name,
        ]);
    }
} 