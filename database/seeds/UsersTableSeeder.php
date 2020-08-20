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
                'remember_token'    => Str::random(10),
                'zip_code'          => '6580053',
                'pref'              => '兵庫県',
                'address'           => '神戸市東灘区住吉宮町',
                'gender'            => 'male',
                'point'             => 0,
                'created_at'        => '2017-08-15 10:00:00',
                'updated_at'        => '2017-08-15 10:00:00'
            ]
        );
        DB::table('users')->insert(
            [
                'name'              => '神戸花子',
                'email'             => 'user2@cooking.sumomo.ne.jp',
                'password'          => Hash::make('pass0123456789'),
                'remember_token'    => Str::random(10),
                'zip_code'          => '6580045',
                'pref'              => '兵庫県',
                'address'           => '神戸市東灘区御影石町',
                'gender'            => 'female',
                'point'             => 0,
                'created_at'        => '2020-07-15 10:00:00',
                'updated_at'        => '2020-07-15 10:00:00'
            ]
        );
        DB::table('users')->insert(
            [
                'name'              => '大阪太郎',
                'email'             => 'user3@cooking.sumomo.ne.jp',
                'password'          => Hash::make('pass0123456789'),
                'remember_token'    => Str::random(10),
                'zip_code'          => '5320024',
                'pref'              => '大阪府',
                'address'           => '大阪市淀川区十三本町',
                'gender'            => 'male',
                'point'             => 0,
                'created_at'        => '2020-01-15 10:00:00',
                'updated_at'        => '2020-01-15 10:00:00'
            ]
        );
        DB::table('users')->insert(
            [
                'name'              => '大阪花子',
                'email'             => 'user4@cooking.sumomo.ne.jp',
                'password'          => Hash::make('pass0123456789'),
                'remember_token'    => Str::random(10),
                'zip_code'          => '5610851',
                'pref'              => '大阪府',
                'address'           => '大阪府豊中市服部元町２丁目',
                'gender'            => 'female',
                'point'             => 0,
                'created_at'        => '2020-08-15 10:00:00',
                'updated_at'        => '2020-08-15 10:00:00'
            ]
        );
    }
}
