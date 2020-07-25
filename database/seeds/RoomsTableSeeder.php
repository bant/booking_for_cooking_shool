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
            'name'              => '住吉教室',
            'staff_id'          => 1,
            'address'           => '神戸市東灘区住吉宮町7-5-10-1',
            'tel'               => '078-856-2583',
            'description'       => '栗田クッキングサロン',
        ]);
        DB::table('rooms')->insert([
            'name'              => '須磨区教室',
            'staff_id'          => 2,
            'address'           => '神戸市東灘区住吉宮町7-5-10-1',
            'tel'               => '078-856-2583',
            'description'       => 'ともクッキングサロン',
        ]);
        DB::table('rooms')->insert([
            'name'              => '北区教室',
            'staff_id'          => 3,
            'address'           => '神戸市東灘区住吉宮町7-5-10-1',
            'tel'               => '078-856-2583',
            'description'       => 'Keiクッキングサロン',
        ]);
        DB::table('rooms')->insert([
            'name'              => '西明石教室',
            'staff_id'          => 4,
            'address'           => '神戸市東灘区住吉宮町7-5-10-1',
            'tel'               => '078-856-2583',
            'description'       => 'クッキングルームHAMA',
        ]);
    }
}
