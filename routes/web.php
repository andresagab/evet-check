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
        Route::get('/users', [\App\Http\Controllers\admin\UserController::class, 'index'])->name('users')->middleware(['ability:*,users']);

        ## ROLES
        Route::get('/roles', [\App\Http\Controllers\admin\RoleController::class, 'index'])->name('roles')->middleware(['ability:*,roles']);

        ## PERMISSIONS
        Route::get('/permission', [\App\Http\Controllers\admin\PermissionController::class, 'index'])->name('permissions')->middleware(['ability:*,permissions']);

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
