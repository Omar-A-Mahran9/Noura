<?php

namespace Database\Seeders;

use App\Models\ConsultationWork;
use Illuminate\Database\Seeder;

class ConsultationWorkSeeder extends Seeder
{

    public function run()
    {
        ConsultationWork::create([
            'name' => 'First Consultation',
            'description' => 'This is the first consultation description.',
            'image' => 'default.jpg',
            'main_image' => 'main_default.jpg',
        ]);
    }
}
