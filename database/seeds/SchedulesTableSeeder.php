<?php

use Illuminate\Database\Seeder;

class SchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('schedules')->insert([
            'owner_id'          => 1,
            'is_zoom'           => 0,
            'title'             => 'テスト教室',
            'description'       => 'テスト教室の詳細',
            'start'             => '2020-06-26T10:00:00',
            'end'               => '2020-06-26T12:00:00',
        ]);
    }
}
