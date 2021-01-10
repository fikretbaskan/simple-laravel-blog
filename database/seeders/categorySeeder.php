<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Str;
use DB;

class categorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories=['Genel','Bilişim','Teknoloji','Güncel Konular'];
        foreach ($categories as $category) {
        DB::table('categories')->insert(
            [
                'name'=>$category,
                'slug'=>Str::slug($category)
            ]
        );
    }
}
}