<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);

        # set custom view for login
        Fortify::loginView(function () {
            return view('pages.login.index');
        });

        # define custom login
        Fortify::authenticateUsing(function (Request $request) {

            # search user in database
            $user = User::query()->where('code', $request->code)->first();

            # if user is not null
            if ($user && Hash::check($request->password, $user->password) && $user->state === 'A')
                return $user;

        });

        # define register view
        Fortify::registerView(function () {
            return view('pages.jet.auth.register');
        });

    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
