<?php

namespace App\Http\Controllers\Sys;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sys\UpdateEventAttendanceRequest;
use App\Models\Sys\Event;
use App\Models\Sys\EventAttendance;
use App\Models\Sys\Person;
use App\Utils\CommonUtils;

class EventAttendanceController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sys\Event  $event
     * @param  \App\Models\Sys\EventAttendance  $attendance
     * @return \Illuminate\View\View
     */
    public function edit(Event $event, EventAttendance $attendance)
    {
        return view('sys.events.attendances.edit', [
            'event' => $event,
            'attendance' => $attendance,
            'people' => Person::query()->orderBy('names')->get(),
            'institutions' => EventAttendance::INSTITUTIONS,
            'participation_modalities' => EventAttendance::PARTICIPATION_MODALITIES,
            'types' => EventAttendance::get_types(),
            'stay_types' => EventAttendance::get_stay_types(),
            'payment_statuses' => EventAttendance::PAYMENT_STATUSES,
            'affirmations' => CommonUtils::AFFIRMATIONS_FROM_BOOLEAN,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Sys\UpdateEventAttendanceRequest  $request
     * @param  \App\Models\Sys\Event  $event
     * @param  \App\Models\Sys\EventAttendance  $attendance
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateEventAttendanceRequest $request, Event $event, EventAttendance $attendance)
    {
        try {
            $attendance->update($request->validated());
            return redirect()->route('sys.events.attendances', $event)->with('success', __('messages.responses.updated'));
        } catch (\Exception $e) {
            error_log("Error => " . $e->getMessage());
            return back()->withErrors(['error' => __('messages.errors.try_error', ['code' => $e->getCode()])])->withInput();
        }
    }
} 