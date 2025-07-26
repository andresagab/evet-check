<?php

namespace App\Http\Controllers\Sys;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sys\UpdateActivityRequest;
use App\Models\Sys\Activity;
use App\Models\Sys\Event;
use App\Models\Sys\Location;

class ActivityController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sys\Activity  $activity
     * @return \Illuminate\View\View
     */
    public function edit(Activity $activity)
    {
        return view('sys.activities.edit', [
            'activity' => $activity,
            'events' => Event::query()->orderBy('name')->get(),
            'locations' => Location::query()->orderBy('name')->get(),
            'types' => Activity::get_types(),
            'modalities' => Activity::get_modalities(),
            'statuses' => Activity::get_status_types(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Sys\UpdateActivityRequest  $request
     * @param  \App\Models\Sys\Activity  $activity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        try {
            $activity->update($request->validated());
            return redirect()->route('sys.activities')->with('success', __('messages.responses.updated'));
        } catch (\Exception $e) {
            error_log("Error => " . $e->getMessage());
            return back()->withErrors(['error' => __('messages.errors.try_error', ['code' => $e->getCode()])])->withInput();
        }
    }
} 