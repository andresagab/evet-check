<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sys\Activity;
use Carbon\Carbon;

class UpdateActivityStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-activity-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and update the status of activities from "Open" to "In progress" if their start date has been reached.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for activities to update...');

        $activities = Activity::query()
            ->where('status', 'O')
            ->where('date', '<=', Carbon::now())
            ->get();

        if ($activities->isEmpty())
        {
            $this->info('No activities to update.');
            return;
        }

        $this->info("Found {$activities->count()} activities to update.");

        foreach ($activities as $activity)
        {
            $activity->status = 'I';
            $activity->save();
            $this->info("Activity #{$activity->id} - '{$activity->name}' updated to 'In progress'.");
        }

        $this->info('All activities updated successfully.');
    }
}
