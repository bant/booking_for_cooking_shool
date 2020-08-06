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
                'name'              => '神戸太郎',
                'email'             => 'user1@cooking.sumomo.ne.jp',
                'password'          => Hash::make('pass0123456789'),
                'address'           => '兵庫県神戸市東灘区住吉宮町',
                'remember_token'    => Str::random(10),
                'point'             => 0
            ]
        );
        DB::table('users')->insert(
            [
                'name'              => '神戸花子',
                'email'             => 'user2@cooking.sumomo.ne.jp',
                'password'          => Hash::make('pass0123456789'),
                'address'           => '兵庫県神戸市東灘区御影石町',
                'remember_token'    => Str::random(10),
                'point'             => 0
            ]
        );
        DB::table('users')->insert(
            [
                'name'              => '大阪太郎',
                'email'             => 'user3@cooking.sumomo.ne.jp',
                'password'          => Hash::make('pass0123456789'),
                'address'           => '大阪府大阪市淀川区十三本町',
                'remember_token'    => Str::random(10),
                'point'             => 0
            ]
        );
        DB::table('users')->insert(
            [
                'name'              => '大阪花子',
                'email'             => 'user4@cooking.sumomo.ne.jp',
                'password'          => Hash::make('pass0123456789'),
                'address'           => '大阪府豊中市',
                'remember_token'    => Str::random(10),
                'point'             => 0
            ]
        );
    }
}
