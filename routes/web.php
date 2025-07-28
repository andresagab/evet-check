<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sys\ActivityController;
use App\Http\Controllers\Sys\EventAttendanceController;
use App\Livewire\Sys\Activities\ActivitiesTable;
use App\Livewire\Sys\Events\Attendances\AttendancesTable;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * redirect root route to login
 */
#Route::redirect('/', '/login');

Route::redirect('/', '/portal/home');
Route::redirect('/portal', '/portal/home');

/*
|--------------------------------------------------------------------------
| PORTAL ROUTES
|--------------------------------------------------------------------------
|
*/

Route::prefix('portal')
    ->name('portal.')
    ->middleware([
    ])
    ->group(function () {

        ## HOME
        Route::get('/home', \App\Livewire\Portal\Home::class)->name('home');

        ## DASHBOARD
        Route::get('/dashboard/{person}', \App\Livewire\Portal\Dashboard::class)->name('dashboard');

        ## ACTIVITIES
        Route::get('/event/{event_id}/activities/{person_id}', \App\Livewire\Portal\Activities::class)->name('event.activities')->withoutScopedBindings();

        ## VIRTUAL CARD
        Route::get('/event/{event_id}/virtual-card/{person_id}', \App\Livewire\Portal\VirtualCard::class)->name('event.virtual-card')->withoutScopedBindings();

    });

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
|
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
        'role:super-user',
    ])
    ->group(function () {

        ## HOME
        Route::get('/home', function () {
            return view('pages.admin.index');
        })->name('home');

        ## USERS
        Route::get('/users', \App\Livewire\Admin\Users\UsersTable::class)->name('users')->middleware(['ability:*,users']);

        ## ROLES
        Route::get('/roles', \App\Livewire\Admin\Roles\RolesTable::class)->name('roles')->middleware(['ability:*,roles']);

        ## PERMISSIONS
        Route::get('/permission', \App\Livewire\Admin\Permissions\PermissionsTable::class)->name('permissions')->middleware(['ability:*,permissions']);

    });

/*
|--------------------------------------------------------------------------
| SYS ROUTES
|--------------------------------------------------------------------------
|
*/

Route::prefix('sys')
    ->name('sys.')
    ->middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])
    ->group(function () {

        ## HOME
        Route::get('/home', function () {
            return view('pages.sys.index');
        })->name('home');

        ## PEOPLE
        Route::get('/people', \App\Livewire\Sys\People\PeopleTable::class)->name('people')->middleware(['ability:*,people']);

        ## EVENTS
        Route::get('/events', \App\Livewire\Sys\Events\EventsTable::class)->name('events')->middleware(['ability:*,events']);

        ## EVENT ATTENDANCES
        Route::get('/events/attendances/{event}', \App\Livewire\Sys\Events\Attendances\AttendancesTable::class)->name('events.attendances')->middleware(['ability:*,event_attendances']);
        # more event_attendances routes
        Route::prefix('event/{event}/attendance/{attendance}')->as('events.attendances.')->group(function () {
            Route::get('edit', [EventAttendanceController::class, 'edit'])->name('edit')->middleware(['ability:*,event_attendances:edit']);
            Route::put('update', [EventAttendanceController::class, 'update'])->name('update')->middleware(['ability:*,event_attendances:edit']);
        });

        ## REPORTS
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('events/{event}/attendees', \App\Livewire\Sys\Reports\EventAttendees::class)->name('events.attendees')->middleware(['ability:*,events:reports:attendees-participation']);
        });

        ## ACTIVITIES
        Route::get('/activities', \App\Livewire\Sys\Activities\ActivitiesTable::class)->name('activities')->middleware(['ability:*,activities']);
        # more activities routes
        Route::prefix('activity/{activity}')->as('activities.')->group(function () {
            Route::get('edit', [ActivityController::class, 'edit'])->name('edit')->middleware(['ability:*,activities:edit']);
            Route::put('update', [ActivityController::class, 'update'])->name('update')->middleware(['ability:*,activities:edit']);
        });

        ## ACTIVITY ATTENDANCE
        Route::get('/activities/attendances/{activity}', \App\Livewire\Sys\Activities\Attendances\AttendanceTable::class)->name('activities.attendances')->middleware(['ability:*,activity_attendances']);

        ## LOCATIONS
        Route::get('/locations', \App\Livewire\Sys\Locations\Table::class)->name('locations')->middleware(['ability:*,locations']);

        Route::get('/certificate-dev', function() {
            $event_attendance = \App\Models\Sys\EventAttendance::query()->find(18);
            $person = \App\Models\Sys\Person::query()->find(18);
            $event = \App\Models\Sys\Event::query()->find(1);
            return view('pages.portal.certificates.certificate-pdf', compact('event', 'person', 'event_attendance'));
        });

    });
