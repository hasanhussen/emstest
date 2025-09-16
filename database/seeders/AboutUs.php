<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutUs extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         About::create([
            'title' => 'وصلة مستشفيات',
            'email' => 'wasleh@gmail.com',
            'facebook' => 'https://www.wasleh.com',
            'instagram' => 'https://www.wasleh.com',
            'twitter' => 'https://www.wasleh.com',
            'whatsApp'=>'0955877410',
            'telegram'=>'0955877410',
            'overview'=>'وصلة مستشفيات',
            'phone'=>'2233445',
            'image'=>'w.jpg',
            ]);
            
    }
}
