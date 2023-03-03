<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\LayoutStyle;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => '$2y$10$zPiaTbYwkxYcejFmEimhWedeAogTJvEb/yGmBVx390ihhPFy8r896' ,//password
                'contact_number'  => null,
                'address'  => null,
                'remember_token' => null,
                'role' => 'admin',
                'isApproved'    => true,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'email_verified_at' => date("Y-m-d H:i:s"),
            ],
            [
                'id'             => 2,
                'name'           => 'Sample Customer',
                'email'          => 'user@user.com',
                'password'       => '$2y$10$zPiaTbYwkxYcejFmEimhWedeAogTJvEb/yGmBVx390ihhPFy8r896',//password
                'contact_number'  => '09776668820',
                'address'  => 'ANTIPOLO CITY',
                'remember_token' => null,
                'role' => 'customer',
                'isApproved'    => true,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'email_verified_at' => date("Y-m-d H:i:s"),
               
            ],
            [
                'id'             => 3,
                'name'           => 'Sample Staff',
                'email'          => 'staff@staff.com',
                'password'       => '$2y$10$zPiaTbYwkxYcejFmEimhWedeAogTJvEb/yGmBVx390ihhPFy8r896',//password
                'contact_number'  => '09776668820',
                'address'  => 'ANTIPOLO CITY',
                'remember_token' => null,
                'role' => 'staff',
                'isApproved'    => true,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'email_verified_at' => date("Y-m-d H:i:s"),
               
            ],
            
        ];
        

        User::insert($users);

        $layout = [
            [
                'id'             => 1,
                'navbar_color'           => '#F8F9FA',
                'navbar_text_color' => '#111',
                'navbar_logo'           => 'logo_black.png',
                'banner_color'           => '#fff',
                'banner_text_color' => '#111',
                'banner_logo'           => 'banner.JPG',

                'slider_image1'           => 'slider1.png',
                'slider_image2'           => 'slider2.png',
                'slider_image3'           => 'slider3.png',
                'slider_image4'           => 'slider4.png',
                'slider_image5'           => 'slider5.png',

                'footer_color'           => '#111',
                'footer_text_color' => '#fff',
                'footer_logo'           => 'banner.JPG',
                

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
           
        ];

        LayoutStyle::insert($layout);

    }
}
