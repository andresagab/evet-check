<?php

use Illuminate\Support\Facades\Route;

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
Route::redirect('/', '/login');

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
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users')->middleware(['ability:*,users']);

        ## ROLES
        Route::get('/roles', [\App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles')->middleware(['ability:*,roles']);

        ## PERMISSIONS
        Route::get('/permission', [\App\Http\Controllers\Admin\PermissionController::class, 'index'])->name('permissions')->middleware(['ability:*,permissions']);

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

        ## ACTIVITIES
        Route::get('/activities', \App\Livewire\Sys\Activities\ActivitiesTable::class)->name('activities')->middleware(['ability:*,activities']);

        ## ACTIVITY ATTENDANCE
        Route::get('/activities/attendances/{activity}', \App\Livewire\Sys\Activities\Attendances\AttendanceTable::class)->name('activities.attendances')->middleware(['ability:*,activity_attendances']);

        # Route::get('/users/profile', \Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm::class);

    });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
