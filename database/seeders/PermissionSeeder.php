<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # create main permissions
        $this->createMainPermissions();
    }

    /**
     * Create main permission of system
     * @return void
     */
    public function createMainPermissions() : void
    {
        # define array of main permissions loading it from config file in admin/permissions.php
        $permissions = Config::get('admin.permissions') ?? [];
        # loop of roles
        foreach ($permissions as $permission) {
            # search current permissions by name
            $r = Permission::query()->where('name', $permission['name'])->first();
            # if role was not fund
            if (!$r)
            {
                # use try catch to save record
                try {
                    Permission::create($permission);
                }
                catch (\Exception $e)
                {
                    error_log($e->getMessage());
                }
            }
        }
    }

}
