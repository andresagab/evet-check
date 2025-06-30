<?php

namespace App\Livewire\Sys\Events\Attendances;

use App\Models\Sys\Activity;
use App\Models\Sys\ActivityAttendance;
use App\Models\Sys\Event;
use App\Models\Sys\EventAttendance;
use App\Models\Sys\Person;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Utils\CommonUtils;

class ImportAttendances extends Component
{
    use WithFileUploads;

    public ?Event $event = null;
    public $file;
    public bool $open = false;

    public array $results = [];
    public string $search_failed_records = '';

    /**
     * Open modal component and setting an event
     * @param Event $event
     * @return void
     */
    #[On('open-import-modal')]
    public function openModal(Event $event) : void
    {
        $this->event = $event;
        $this->reset('file', 'results');
        $this->open = true;
    }

    /**
     * Close modal component
     * @return void
     */
    public function closeModal() : void
    {
        $this->open = false;
        $this->reset('file', 'results');
    }

    /**
     * Import attendances from file
     * @return void
     */
    public function import() : void
    {
        # validate file
        $this->validate([
            'file' => 'required|mimes:json,csv,txt'
        ]);

        # get file path and extension
        $path = $this->file->getRealPath();
        $extension = $this->file->getClientOriginalExtension();

        # get data from file
        if ($extension === 'json') {
            $data = json_decode(file_get_contents($path), true);
        } else { // csv
            $csvData = array_map('str_getcsv', file($path));
            if (count($csvData) > 0)
            {
                $header = array_shift($csvData);
                $data = array_map(function ($row) use ($header) {
                    if (count($header) == count($row))
                        return array_combine($header, $row);
                    return false;
                }, $csvData);
                $data = array_filter($data);
            } else
                $data = [];
        }

        # if data is empty
        if (empty($data))
        {
            $this->dispatch('toast', title: 'El archivo está vacío o tiene un formato incorrecto.', icon: 'warning');
            return;
        }


        # define counters and arrays
        $saved_records = 0;
        $read_records = 0;
        $failed_records = [];

        # load init activities
        $activities = Activity::query()->whereRaw('LOWER(name) LIKE ?', ["Refrigerio%"])->get();

        # init db transaction
        DB::transaction(function () use ($data, &$saved_records, &$read_records, &$failed_records, $activities) {

            # loop data
            foreach ($data as $index => $item) {
                $read_records++;
                $row_number = $index + 2; // for csv with header

                if (!empty($item))
                {
                    # trim each attribute of item
                    $item = array_map('trim', $item);
                }

                # validate item
                $validator = Validator::make($item, [
                    'nuip' => 'required',
                    'names' => 'required|string',
                    'surnames' => 'required|string',
                    'cel' => 'nullable|string',
                    'phone' => 'nullable|string',
                    'email' => 'nullable|email',
                    'institution_name' => 'required|string',
                    'other_institution' => 'nullable|string',
                    'participation_modality' => 'required|string',
                    'type' => 'nullable|string',
                    'stay_type' => 'nullable|string',
                    'payment_status' => 'nullable|string',
                ]);

                # if validator fails
                if ($validator->fails()) {
                    $failed_records[] = [
                        'row' => $row_number,
                        'data' => $item,
                        'errors' => $validator->errors()->all(),
                    ];
                    continue;
                }

                # try save record
                try {
                    # search person by nuip
                    $person = Person::query()->where('nuip', $item['nuip'])->first();

                    # if person was not found
                    if (empty($person))
                    {
                        # explode names and surnames
                        $names_explode = explode(' ', $item['names']);
                        $surnames_explode = explode(' ', $item['surnames']);

                        # create new user model
                        $user = new User();
                        # set attributes
                        $user->name = ucwords(mb_strtolower($names_explode[0] . " " . $surnames_explode[0], 'UTF-8'));
                        $user->code = trim($item['nuip']);
                        $user->state = 'A';
                        $user->password = Hash::make(strtoupper(substr($names_explode[0], 0, 1)) . strtoupper(substr($surnames_explode[0], 0, 1)) . $item['nuip']);

                        # if user was saved
                        if ($user->save())
                        {
                            # sync assistant role to user
                            $user->addRole('assistant');

                            # reset as new model
                            $person = new Person();
                            # set attributes
                            $person->names = ucwords(mb_strtolower($item['names'], 'UTF-8'));
                            $person->surnames = ucwords(mb_strtolower($item['surnames'], 'UTF-8'));
                            $person->nuip = trim($item['nuip']);
                            $person->sex = null;
                            $person->cel = trim($item['cel'] ?? null);
                            $person->phone = trim($item['phone'] ?? null);
                            $person->email = trim($item['email'] ?? null);
                            $person->user_id = $user->id;

                            $person->save();
                        }
                    }

                    # check if event attendance already exists
                    $event_attendance_exists = EventAttendance::query()
                        ->where('event_id', $this->event->id)
                        ->where('person_id', $person->id)
                        ->exists();

                    if ($event_attendance_exists) {
                        $failed_records[] = [
                            'row' => $row_number,
                            'data' => $item,
                            'errors' => ['Ya existe una inscripción para esta persona en este evento.'],
                        ];
                        continue;
                    }

                    # search institution_id
                    $institution_id = array_search($item['institution_name'], EventAttendance::INSTITUTIONS);
                    $other_institution = $item['other_institution'] ?? null;
                    if (!$institution_id && !$other_institution) {
                        $institution_id = 1;
                        $other_institution = $item['institution_name'];
                    }

                    # search participation_modality
                    $participation_modality = array_search($item['participation_modality'], Lang::get('messages.models.event_attendance.participation_modalities'));
                    # search type
                    $type = array_search($item['type'], EventAttendance::get_types());
                    # search stay_type
                    $stay_type = array_search($item['stay_type'], EventAttendance::get_stay_types());
                    # search payment_status
                    $payment_status = array_search($item['payment_status'], EventAttendance::PAYMENT_STATUSES);

                    # create event attendance
                    EventAttendance::create([
                        'event_id' => $this->event->id,
                        'person_id' => $person->id,
                        'institution_id' => $institution_id,
                        'other_institution' => $other_institution,
                        'participation_modality' => $participation_modality,
                        'type' => $type !== false ? $type : 'ND',
                        'stay_type' => $stay_type !== false ? $stay_type : 'P',
                        'payment_status' => $payment_status !== false ? $payment_status : 'NP',
                    ]);

                    # if count of initial activities is greater than 0
                    foreach ($activities as $activity) {
                        # create attendance of activity by person
                        ActivityAttendance::create([
                            'activity_id' => $activity->id,
                            'person_id' => $person->id,
                            'state' => 'SU',
                        ]);
                    }

                    $saved_records++;

                } catch (\Exception $e) {
                    $failed_records[] = [
                        'row' => $row_number,
                        'data' => $item,
                        'errors' => [$e->getMessage()],
                    ];
                }
            }
        });

        $this->results = [
            'read_records' => $read_records,
            'saved_records' => $saved_records,
            'failed_records_count' => count($failed_records),
            'failed_records' => $failed_records,
        ];

        # dispatch toast
        $this->dispatch('toast', title: 'Proceso de importación finalizado');
        # refresh parent
        $this->dispatch('search', true, true);
    }

    /**
     * Render view of component
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        $failed_records = [];

        if (!empty($this->results['failed_records'])) {
            $search = mb_strtolower($this->search_failed_records, 'UTF-8');
            if (!empty($search)) {
                $failed_records = array_filter($this->results['failed_records'], function ($record) use ($search) {
                    $dataString = mb_strtolower(json_encode($record['data']), 'UTF-8');
                    $errorsString = mb_strtolower(json_encode($record['errors']), 'UTF-8');
                    return str_contains($dataString, $search) || str_contains($errorsString, $search);
                });
            } else {
                $failed_records = $this->results['failed_records'];
            }
        }

        return view('livewire.sys.events.attendances.import-attendances', [
            'failed_records_list' => $failed_records,
        ]);
    }
} 