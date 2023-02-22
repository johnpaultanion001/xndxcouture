<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name'              => 'T-SHIRT',
                
                'created_at'          => date("Y-m-d H:i:s"),
                'updated_at'          => date("Y-m-d H:i:s"),
            ],
            [
                'name'             => 'SHORT',
                
                'created_at'          => date("Y-m-d H:i:s"),
                'updated_at'          => date("Y-m-d H:i:s"),
            ],
            [
                'name'             => 'PANTS',
                
                'created_at'          => date("Y-m-d H:i:s"),
                'updated_at'          => date("Y-m-d H:i:s"),
            ],
            [
                'name'             => 'POLO',
                
                'created_at'          => date("Y-m-d H:i:s"),
                'updated_at'          => date("Y-m-d H:i:s"),
            ],
           
        ];
       
        Category::insert($categories);
    }
}
