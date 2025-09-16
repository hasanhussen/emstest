<?php

namespace Database\Seeders;

use App\Models\PrivacyPolicy as ModelsPrivacyPolicy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrivacyPolicy extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsPrivacyPolicy::create([
            'title' => 'وصلة مستشفيات',
            'body' => 'سياسة الخصوصية ل وصلة مستشفيات ',
         
            ]);
    }
}
