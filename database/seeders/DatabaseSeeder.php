<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([ConfigsSeeder::class,RolesSeeder::class,PermissionsSeeder::class,PermissionsRolesSeeder::class,AdminsSeeder::class,CategorySeeder::class]);
    }
}
