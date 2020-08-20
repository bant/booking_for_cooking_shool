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
        DB::table('admins')->insert(
            [
                'name'              => '管理人1号',
                'email'             => 'admin1@cooking.sumomo.ne.jp',
                'password'          => Hash::make('pass0123456789'),
                'remember_token'    => Str::random(10),
                'created_at'        => '2020-08-15 10:00:00',
                'updated_at'        => '2020-08-15 10:00:00'
            ] 
        );
        DB::table('admins')->insert(
            [
                'name'              => '管理人2号',
                'email'             => 'two@admin.com',
                'password'          => Hash::make('pass0123456789'),
                'remember_token'    => Str::random(10),
                'created_at'        => '2020-08-15 10:00:00',
                'updated_at'        => '2020-08-15 10:00:00'
            ]
        );
        DB::table('admins')->insert(
            [
                'name'              => '管理人3号',
                'email'             => 'tree@admin.com',
                'password'          => Hash::make('pass0123456789'),
                'remember_token'    => Str::random(10),
                'created_at'        => '2020-08-15 10:00:00',
                'updated_at'        => '2020-08-15 10:00:00'
            ]
        );
    }
}
