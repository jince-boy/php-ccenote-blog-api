<?php

namespace Database\Seeders;

use App\Models\Configs;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ConfigsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Configs::create([
            'title'=>'我的网站程序',
            'description'=>null,
            'keywords'=>null,
            'logo'=>asset('/images/logo/logo.png'),
            'is_register'=>1,
            'site_status'=>1,
            'close_reason'=>null,
            'copyright'=>'Copyright ©2021-2022 ccenote(www.ccenote.com), All Rights Reserved',
            'record'=>'备案',
            'edition'=>'1.0.0',
            'front_page_num'=>6,
            'back_page_num'=>10,
            'contact'=>null,
            'notice'=>null,
            'grey'=>'0',
            'running_time'=>Carbon::now()->toDateTimeString()
        ]);
    }
}
