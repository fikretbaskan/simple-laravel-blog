<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

use DB,Str;

class articleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i=0; $i < 4; $i++) { 
            $title = $faker->sentence(6);
            DB::table('articles')->insert([
                'category_id'=>rand(1,3),
                'title'=> $title,
                'image'=>$faker->imageUrl(800,400,'cats',true,'Faker'),
                'content'=>$faker->paragraph(6),
                'slug'=>Str::slug($title)
            ]);
        }
    }
}
