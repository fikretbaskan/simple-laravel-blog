<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB,Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages=['About','Career','Vision','Mission'];
        $count = 0;
        foreach ($pages as $page) {
        $count++;
        DB::table('pages')->insert(
            [
                'title'=>$page,
                'slug'=>Str::slug($page),
                'content'=>"Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro illum repellendus vero maxime eum quas itaque sapiente illo architecto qui. Magnam dolore ad nulla odio maxime vitae officiis corrupti aliquid.",
                'order'=>$count,
                'image'=>'fsdf'
            ]
        );
    }
}
}
