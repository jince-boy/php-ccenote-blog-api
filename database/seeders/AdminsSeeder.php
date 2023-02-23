<?php

namespace Database\Seeders;

use App\Models\Admins;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admins::create([
            'username'=>env("DEFAULT_USERNAME","ChinaClown"),
            'password'=>Hash::make(env("DEFAULT_PASSWORD","123123123")),
            //默认密码123123123
            'name'=>'管理员',
            'email'=>env("DEFAULT_EMAIL","xxxx@163.com"),
            'url'=>'http://ccenote.com',
            'profile'=>'做最有意义的事情，成就最有价值的梦想，展现最真实的自己，超越自己，改变世界。',
            'avatar'=>asset('/images/avatar/avatar.jpg'),
            'status'=>1,
            'role_id'=>1
        ]);
    }
}
