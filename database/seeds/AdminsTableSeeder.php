<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name'              => 'ばんと',
            'email'             => 'bant62@gmail.com',
            'password'          => Hash::make('osame123'),
            'remember_token'    => Str::random(10),
        ]);
    }
}
