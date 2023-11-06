<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # create main roles
        $this->createMainRoles();
    }

    /**
     * create main roles of system
     * @return void
     */
    private function createMainRoles() : void
    {
        # define array of main roles
        $roles = Config::get('admin.roles.roles');
        # loop of roles
        foreach ($roles as $role) {
            # search current role by name
            $r = Role::query()->where('name', $role['name'])->first();
            # if role was not fund
            if (!$r) {
                # use try catch to save record
                try {
                    Role::create($role);
                } catch (\Exception $e) {
                    error_log($e->getMessage());
                }
            }
        }
    }

}
