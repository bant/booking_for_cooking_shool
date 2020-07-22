<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'name'              => '生徒1号',
                'email'             => 'user1@cooking.sumomo.ne.jp',
                'password'          => Hash::make('pass0123456789'),
                'remember_token'    => Str::random(10),
                'point'             => 1000000
            ]
        );
        DB::table('users')->insert(
            [
                'name'              => '生徒2号',
                'email'             => 'two@user.com',
                'password'          => Hash::make('pass0123456789'),
                'remember_token'    => Str::random(10),
                'point'             => 0
            ]
        );
        DB::table('users')->insert(
            [
                'name'              => '生徒3号',
                'email'             => 'tree@user.com',
                'password'          => Hash::make('pass0123456789'),
                'remember_token'    => Str::random(10),
                'point'             => 50000
            ]
        );
    }
}
