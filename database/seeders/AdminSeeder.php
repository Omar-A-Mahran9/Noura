<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create([
            'name' => 'OmarSupport',
            'email' => 'omar.a.m.mahran@gmail.com',
            'password' => 'nora123',
            'phone' => '966522334455',
        ]);
        Employee::create([
            'name' => 'nora Live',
            'email' => 'nora@gmail.com',
            'password' => 'nora123',
            'phone' => '966511223344',
        ]);
    }
}
