<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->create_superuser();
    }

    /**
     * Create main user
     * @return void
     */
    private function create_superuser() : void
    {
        # create user
        $user = new User();
        # set user attributes
        $user->name = env('APP_SUPERUSER_NAME');
        $user->code = env('APP_SUPERUSER_CODE');
        $user->password = Hash::make(env('APP_SUPERUSER_PASSWORD'));

        # if user don't exist
        if (User::query()->where('code', $user->code)->count() === 0)
        {
            try {
                # store user
                $user->save();
                # add role to user
                $user->addRole('super-user');
                # load all permissions from db
                $permissions = Permission::query()->pluck('id')->toArray();
                # sync permission to user
                $user->syncPermissions($permissions);
            }
            catch (\Exception $e)
            {
                error_log("Error: {$e->getMessage()}");
            }
        }

    }

}
