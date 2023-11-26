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
        $this->create_init_activities();
    }

    private function create_init_activities() : void
    {

        # search event by name
        $event = Event::query()->where('name', env('APP_MAIN_EVENT_NAME'))->first();
        # if event was fund
        if (!empty($event))
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

}
