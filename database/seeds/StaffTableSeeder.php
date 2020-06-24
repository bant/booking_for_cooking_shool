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
            'name'              => 'staff',
            'email'             => 'staff@test.com',
            'password'          => Hash::make('staff'),
            'remember_token'    => Str::random(10),
        ]);
    }
}
