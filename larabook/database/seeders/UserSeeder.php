<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'first_name' => 'Andreas',
            'last_name' => 'Jakobsen',
            'password' => Hash::make('aa@aa.no'),
            'email' => 'aa@aa.no',
            'address' => 'havnegata 24',
            'city' => 'Stokmarknes',
            'postal' => '8450',
            'company' => 'Hadsel Taxi',
            'phone' => 99050666
        ]);
    }
}
