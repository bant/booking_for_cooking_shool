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
            'address'           => '神戸市東灘区住吉宮町7-5-19-1',
            'tel'               => '078-856-2583',
            'description'       => '栗田クッキングサロン',
        ]);
        DB::table('rooms')->insert([
            'name'              => '須磨区教室',
            'staff_id'          => 2,
            'address'           => '神戸市須磨区桜の杜１丁目',
            'tel'               => '090-7844-4058',
            'description'       => 'ともクッキングサロン',
        ]);
        DB::table('rooms')->insert([
            'name'              => '北区教室',
            'staff_id'          => 3,
            'address'           => '神戸市北区上津台６丁目',
            'tel'               => '090-3058-7921',
            'description'       => 'Keiクッキングサロン',
        ]);
        DB::table('rooms')->insert([
            'name'              => '西明石教室',
            'staff_id'          => 4,
            'address'           => '明石市松の内2丁目',
            'tel'               => ' 090-7881-6724',
            'description'       => 'クッキングルームHAMA',
        ]);
    }
}
