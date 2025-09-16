<?php

namespace Database\Seeders;

use Database\Seeders\CitySeeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\PermissionTableSeeder;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\AboutUs;
use Database\Seeders\PrivacyPolicy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            CountrySeeder::class,
            CitySeeder::class,

            // Seeder للأذونات
            PermissionTableSeeder::class,

            // Seeder للمستخدمين
            AdminUserSeeder::class,

            // Seeders للمحتوى العام
            AboutUs::class,
            PrivacyPolicy::class,
        ]);

    }
}
