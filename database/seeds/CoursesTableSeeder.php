<?php

use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('courses')->insert(
            [
                'staff_id'          => 1,
                'name'              => '家庭料理',
                'price'             => 6000,
//                'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 1,
                'name'              => '魚をさばく料理',
                'price'             => 6000,
  //              'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 1,
                'name'              => 'バラエテイコース',
                'price'             => 6000,
    //            'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 1,
                'name'              => '日本料理',
                'price'             => 10000,
     //           'price_down'        => 8000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 1,
                'name'              => 'パン・お菓子',
                'price'             => 6000,
    //            'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 1,
                'name'              => '基本料理(和食)',
                'price'             => 5000,
     //           'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 1,
                'name'              => '基本料理(中華)',
                'price'             => 5000,
    //            'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 1,
                'name'              => 'スターター(洋食)',
                'price'             => 4500,
    //            'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 1,
                'name'              => 'スターター(中華)',
                'price'             => 4500,
    //            'price_down'        => 4000,
            ]
        );

        DB::table('courses')->insert(
            [
                'staff_id'          => 2,
                'name'              => '家庭料理',
                'price'             => 6000,
//                'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 2,
                'name'              => '魚をさばく料理',
                'price'             => 6000,
  //              'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 2,
                'name'              => 'バラエテイコース',
                'price'             => 6000,
    //            'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 2,
                'name'              => '日本料理',
                'price'             => 10000,
     //           'price_down'        => 8000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 2,
                'name'              => 'パン・お菓子',
                'price'             => 6000,
    //            'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 2,
                'name'              => '基本料理(和食)',
                'price'             => 5000,
     //           'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 2,
                'name'              => '基本料理(中華)',
                'price'             => 5000,
    //            'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 2,
                'name'              => 'スターター(洋食)',
                'price'             => 4500,
    //            'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 2,
                'name'              => 'スターター(中華)',
                'price'             => 4500,
    //            'price_down'        => 4000,
            ]
        );
        

        DB::table('courses')->insert(
            [
                'staff_id'          => 3,
                'name'              => '家庭料理',
                'price'             => 6000,
//                'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 3,
                'name'              => '魚をさばく料理',
                'price'             => 6000,
  //              'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 3,
                'name'              => 'バラエテイコース',
                'price'             => 6000,
    //            'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 3,
                'name'              => '日本料理',
                'price'             => 10000,
     //           'price_down'        => 8000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 3,
                'name'              => 'パン・お菓子',
                'price'             => 6000,
    //            'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 3,
                'name'              => '基本料理(和食)',
                'price'             => 5000,
     //           'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 3,
                'name'              => '基本料理(中華)',
                'price'             => 5000,
    //            'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 3,
                'name'              => 'スターター(洋食)',
                'price'             => 4500,
    //            'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 3,
                'name'              => 'スターター(中華)',
                'price'             => 4500,
    //            'price_down'        => 4000,
            ]
        );

        DB::table('courses')->insert(
            [
                'staff_id'          => 4,
                'name'              => '家庭料理',
                'price'             => 6000,
//                'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 4,
                'name'              => '魚をさばく料理',
                'price'             => 6000,
  //              'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 4,
                'name'              => 'バラエテイコース',
                'price'             => 6000,
    //            'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 4,
                'name'              => '日本料理',
                'price'             => 10000,
     //           'price_down'        => 8000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 4,
                'name'              => 'パン・お菓子',
                'price'             => 6000,
    //            'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 4,
                'name'              => '基本料理(和食)',
                'price'             => 5000,
     //           'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 4,
                'name'              => '基本料理(中華)',
                'price'             => 5000,
    //            'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 4,
                'name'              => 'スターター(洋食)',
                'price'             => 4500,
    //            'price_down'        => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 4,
                'name'              => 'スターター(中華)',
                'price'             => 4500,
    //            'price_down'        => 4000,
            ]
        );

    }
}
