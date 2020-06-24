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
            'name'              => 'admin',
            'email'             => 'admin@test.com',
            'password'          => Hash::make('admin'),
            'remember_token'    => Str::random(10),
        ]);
    }
}
