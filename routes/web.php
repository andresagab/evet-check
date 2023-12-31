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
