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
                'name'              => '神戸　太郎',
                'kana'              => 'コウベ　タロウ',
                'email'             => 'user1@cooking.sumomo.ne.jp',
                'password'          => Hash::make('pass0123456789'),
                'remember_token'    => Str::random(10),
                'zip_code'          => '658-0053',
                'tel'               => '078-123-4567',
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
                'name'              => '神戸　花子',
                'kana'              => 'コウベ　ハナコ',
                'email'             => 'user2@cooking.sumomo.ne.jp',
                'password'          => Hash::make('pass0123456789'),
                'remember_token'    => Str::random(10),
                'zip_code'          => '658-0045',
                'tel'               => '078-234-5678',
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
                'name'              => '大阪　太郎',
                'kana'              => 'オオサカ　タロウ',
                'email'             => 'user3@cooking.sumomo.ne.jp',
                'password'          => Hash::make('pass0123456789'),
                'remember_token'    => Str::random(10),
                'zip_code'          => '532-0024',
                'tel'               => '06-1234-5678',
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
                'name'              => '大阪　花子',
                'kana'              => 'オオサカ　ハナコ',
                'email'             => 'user4@cooking.sumomo.ne.jp',
                'password'          => Hash::make('pass0123456789'),
                'remember_token'    => Str::random(10),
                'zip_code'          => '561-0851',
                'tel'               => '06-2345-6789',
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
