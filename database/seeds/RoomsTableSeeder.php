<?php

use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([
            'name'              => '東淀川教室',
            'staff_id'          => 1,
            'address'           => '大阪市東淀川',
            'tel'               => '06-9999-9999',
            'description'       => '家庭料理中心',
        ]);
    }
}
