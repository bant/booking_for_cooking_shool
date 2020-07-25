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
        DB::table('staff')->insert(
            [
                'name'              => '栗田登志子',
                'email'             => 'staff1@cooking.sumomo.ne.jp',
                'password'          => Hash::make('pass0123456789'),
                'remember_token'    => Str::random(10),
                'is_zoom'           => true,
            ]
        );
        DB::table('staff')->insert(
            [
                'name'              => '新吉友子',
                'email'             => 'staff2@cooking.sumomo.ne.jp',
                'password'          => Hash::make('pass0123456789'),
                'remember_token'    => Str::random(10),
                'is_zoom'           => false,
            ]
        );
        DB::table('staff')->insert(
            [
                'name'              => '高橋景子',
                'email'             => 'staff3@cooking.sumomo.ne.jp',
                'password'          => Hash::make('pass0123456789'),
                'remember_token'    => Str::random(10),
                'is_zoom'           => true,
            ]
        );

        DB::table('staff')->insert(
            [
                'name'              => '濱本知恵',
                'email'             => 'staff4@cooking.sumomo.ne.jp',
                'password'          => Hash::make('pass0123456789'),
                'remember_token'    => Str::random(10),
                'is_zoom'           => true,
            ]
        );
    }
}