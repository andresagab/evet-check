<?php

namespace Database\Seeders;

use App\Models\Sys\Activity;
use App\Models\Sys\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # calls
        $this->import_main_activities();
        $this->create_init_activities();
    }

    private function create_init_activities() : void
    {

        # search event by name
        $event = Event::query()->where('name', env('APP_MAIN_EVENT_NAME'))->first();
        # if event was fund and not have registered activities
        if (!empty($event) && Activity::query()->count() === 0)
        {
            # define amount of activities
            $amount = 3;
            # loop to create N activities
            for ($i = 1; $i <= $amount; $i++)
            {
                # create activity of event
                Activity::create([
                    'event_id' => $event->id,
                    'author_name' => "Licenciatura en Informática - UDENAR (2023)",
                    'name' => "Refrigerio $i",
                    'slots' => 500,
                    'type' => 'SN',
                    'modality' => 'P',
                    'status' => 'O',
                    'hide' => 1,
                    'date' => "2023-11-29 10:30:00",
                ]);
            }
        }

    }

    /**
     * Import main activities from json
     * @return void
     */
    private function import_main_activities() : void
    {

        # search event by name
        $event = Event::query()->where('name', env('APP_MAIN_EVENT_NAME'))->first();
        # if event was fund
        if (!empty($event) && Activity::query()->count() > 0)
        {

            # define file path with json data
            $filepath = public_path("assets\\" . env('APP_ACTIVITIES_DATA_PATH'));

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

                    # search activity by name
                    $activity = Activity::query()->where('name', $item['name'])->first();

                    # if activity not was fund
                    if (empty($activity))
                    {

                        # search type
                        $type = array_search($item['type'], Activity::get_types());
                        # search modality
                        $modality = array_search($item['modality'], Activity::get_modalities());

                        #$explode_date = explode(' ', $item['date']);
                        #$date = "{$explode_date[0]} " . str_replace('-', ':', $explode_date[1]);

                        # reset as new model
                        $activity = new Activity();
                        # set attributes
                        $activity->author_name = $item['author_name'];
                        $activity->name = $item['name'];
                        $activity->slots = $item['slots'];
                        $activity->type = $type;
                        $activity->modality = $modality;
                        $activity->status = $item['status'];
                        $activity->hide = $item['hide'];
                        $activity->date = $item['date'];
                        $activity->event_id = $event->id;

                        # if person was saved
                        if ($activity->save())
                            $saved_records++;

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
