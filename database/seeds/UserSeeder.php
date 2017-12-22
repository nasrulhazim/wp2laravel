<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \WPTL\Models\User::create([
            'name'           => 'Nasrul Hazim',
            'email'          => 'nasrulhazim.m@gmail.com',
            'password'       => bcrypt('password'),
            'remember_token' => str_random(10),
        ])->assignRole(['administrator', 'user']);
    }
}
