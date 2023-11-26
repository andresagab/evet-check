<?php

namespace Database\Seeders;

use App\Models\Sys\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # calls
        $this->create_main_event();
    }

    /**
     * Create main event
     * @return void
     */
    public function create_main_event() : void
    {
        # search event by name
        $event = Event::query()->where('name', env('APP_MAIN_EVENT_NAME'))->first();

        # if event wasn't fund
        if (empty($event))
        {
            # reset as new model
            $event = new Event();
            # set attributes
            $event->name = env('APP_MAIN_EVENT_NAME');
            $event->year = env('APP_MAIN_EVENT_YEAR');
            $event->symbolic_cost = env('APP_MAIN_EVENT_SYMBOLIC_COST');
            $event->state = 'OP';

            try {
                $event->save();
            }
            catch (\Exception $e)
            {
                error_log("Error: {$e->getMessage()}");
            }

        }

    }

}
