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
                'name'              => '先生1号',
                'email'             => 'staff1@cooking.sumomo.ne.jp',
                'password'          => Hash::make('pass0123456789'),
                'remember_token'    => Str::random(10),
                'is_zoom'           => true,
            ]
        );
        DB::table('staff')->insert(
            [
                'name'              => '先生2号',
                'email'             => 'two@staff.com',
                'password'          => Hash::make('pass0123456789'),
                'remember_token'    => Str::random(10),
                'is_zoom'           => false,
            ]
        );
        DB::table('staff')->insert(
            [
                'name'              => '先生3号',
                'email'             => 'tree@staff.com',
                'password'          => Hash::make('pass0123456789'),
                'remember_token'    => Str::random(10),
                'is_zoom'           => true,
            ]
        );
    }
}