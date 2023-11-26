<?php

namespace Database\Seeders;

use App\Models\Sys\Activity;
use App\Models\Sys\ActivityAttendance;
use App\Models\Sys\Event;
use App\Models\Sys\EventAttendance;
use App\Models\Sys\Person;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # calls
        $this->create_main_people();
    }

    /**
     * Create main people data from file
     * @return void
     */
    private function create_main_people() : void
    {

        # search event by name
        $event = Event::query()->where('name', env('APP_MAIN_EVENT_NAME'))->first();
        # if event was fund
        if (!empty($event))
        {

            # load init activities
            $activities = Activity::query()->whereRaw('LOWER(name) LIKE ?', ["Refrigerio%"])->get();

            # define file path with json data
            $filepath = public_path("assets\\" . env('APP_PERSON_DATA_PATH'));

            # if exist file
            if (file_exists($filepath))
            {

                # get json data
                $json = json_decode(file_get_contents($filepath), true);

                # define count of read_records and saved_records
                $read_records = 0;
                $saved_records = 0;
                $existing_records = 0;

                # loop json
                foreach ($json as $item) {

                    $read_records++;

                    # search person by nuip
                    $person = Person::query()->where('nuip', $item['nuip'])->first();

                    # if $cupsCode not was fund
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
                            $person->cel = trim($item['cel']);
                            $person->phone = trim($item['phone']);
                            $person->email = trim($item['email']);
                            $person->user_id = $user->id;

                            # if person was saved
                            if ($person->save())
                            {

                                # search institution_id
                                $institution_id = array_search($item['institution_name'], EventAttendance::INSTITUTIONS);
                                # search participation_modality
                                $participation_modality = array_search($item['participation_modality'], Lang::get('messages.models.event_attendance.participation_modalities'));
                                # search type
                                $type = array_search($item['type'], EventAttendance::get_types());
                                # search stay_type
                                $stay_type = array_search($item['stay_type'], EventAttendance::get_stay_types());

                                # create event attendance
                                EventAttendance::create([
                                    'event_id' => $event->id,
                                    'person_id' => $person->id,
                                    'institution_id' => $institution_id,
                                    'other_institution' => $item['other_institution'],
                                    'participation_modality' => $participation_modality,
                                    'type' => $type,
                                    'stay_type' => $stay_type,
                                    'payment_status' => $item['payment_status'],
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

                            }

                        }


                    }
                    else
                        $existing_records++;
                }

                # log result
                error_log("Read records: $read_records");
                error_log("Saved records: $saved_records");
                error_log("Existing records: $existing_records");

            }
            else
                error_log('File not found');

        }

    }

}
