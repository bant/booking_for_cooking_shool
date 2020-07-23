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
            'staff_id'          => 1,
            'capacity'          => 4,
            'is_zoom'           => 0,
            'title'             => 'テスト教室',
            'description'       => 'テスト教室の詳細',
            'start'             => '2020-07-26 10:00',
            'end'               => '2020-07-26 12:00',
        ]);
    }
}
