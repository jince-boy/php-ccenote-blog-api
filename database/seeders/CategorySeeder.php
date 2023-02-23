<?php

namespace Database\Seeders;

use App\Models\Categorys;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categorys::create([
            'name'=>'未分类',
            'description'=>'未分类文章',
            'icon'=>'icon-taiyang-copy',
            'is_menu'=>'1',
            'order'=>1,
        ]);
    }
}
