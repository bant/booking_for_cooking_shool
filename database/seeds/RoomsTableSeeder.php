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
            'name'              => 'ばんとの教室',
            'staff_id'          => 1,
            'address'           => '大阪市',
            'description'       => '家庭料理中心',
        ]);
    }
}
