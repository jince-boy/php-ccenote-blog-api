<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name'=>'超级管理员',
                'description'=>"超级管理员(系统)"
            ],
            [
                'name'=>'管理员',
                'description'=>"管理员(系统)"
            ],
            [
                'name'=>"作者",
                'description'=>"作者(系统)"
            ]
        ]);
    }
}
