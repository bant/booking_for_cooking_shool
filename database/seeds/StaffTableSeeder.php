<?php

use Illuminate\Database\Seeder;

class StaffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('staff')->insert([
            'name'              => 'ばんと',
            'email'             => 'bant62@gmail.com',
            'password'          => Hash::make('osame123'),
            'remember_token'    => Str::random(10),
        ]);
    }
}
