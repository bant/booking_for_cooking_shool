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
                'name'              => 'スターター(リアル教室)',
                'price'             => 4500,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 1,
                'name'              => 'スターター(オンライン)',
                'price'             => 3000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 1,
                'name'              => '基本料理(リアル教室)',
                'price'             => 5000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 1,
                'name'              => '基本料理(オンライン)',
                'price'             => 3000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 1,
                'name'              => '家庭料理(リアル教室)',
                'price'             => 6000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 1,
                'name'              => '家庭料理(オンライン)',
                'price'             => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 1,
                'name'              => '魚を捌く料理(リアル教室)',
                'price'             => 6000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 1,
                'name'              => '魚を捌く料理(オンライン)',
                'price'             => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 1,
                'name'              => 'バラエティ(リアル教室)',
                'price'             => 6000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 1,
                'name'              => 'バラエティ(オンライン)',
                'price'             => 4000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 1,
                'name'              => 'パン・お菓子(リアル教室)',
                'price'             => 6000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 1,
                'name'              => '日本料理(リアル教室)',
                'price'             => 10000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 1,
                'name'              => '講師養成(オンライン)',
                'price'             => 150000,
            ]
        );

        DB::table('courses')->insert(
            [
                'staff_id'          => 2,
                'name'              => 'スターター(リアル教室)',
                'price'             => 4500,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 2,
                'name'              => 'スターター(オンライン)',
                'price'             => 3000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 2,
                'name'              => '基本料理(リアル教室)',
                'price'             => 5000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 2,
                'name'              => '基本料理(オンライン)',
                'price'             => 3000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 2,
                'name'              => '家庭料理(リアル教室)',
                'price'             => 6000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 2,
                'name'              => '魚を捌く料理(リアル教室)',
                'price'             => 6000,
            ]
        );

        DB::table('courses')->insert(
            [
                'staff_id'          => 2,
                'name'              => '美味しいおうち薬膳(リアル教室)',
                'price'             => 5000,
            ]
        );

        DB::table('courses')->insert(
            [
                'staff_id'          => 3,
                'name'              => 'スターター(リアル教室)',
                'price'             => 4500,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 3,
                'name'              => '基本料理(リアル教室)',
                'price'             => 5000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 3,
                'name'              => '家庭料理(リアル教室)',
                'price'             => 6000,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 3,
                'name'              => '魚を捌く料理(リアル教室)',
                'price'             => 6000,
            ]
        );

        DB::table('courses')->insert(
            [
                'staff_id'          => 3,
                'name'              => '手ごねパンとヘルシースイーツ(リアル教室)',
                'price'             => 6000,
            ]
        );

        DB::table('courses')->insert(
            [
                'staff_id'          => 3,
                'name'              => 'ナチュラル(リアル教室)',
                'price'             => 5000,
            ]
        );

        DB::table('courses')->insert(
            [
                'staff_id'          => 4,
                'name'              => 'スターター(リアル教室)',
                'price'             => 4500,
            ]
        );
        DB::table('courses')->insert(
            [
                'staff_id'          => 4,
                'name'              => '基本料理(リアル教室)',
                'price'             => 5000,
            ]
        );

        DB::table('courses')->insert(
            [
                'staff_id'          => 4,
                'name'              => '魚を捌く料理(リアル教室)',
                'price'             => 6000,
            ]
        );

        DB::table('courses')->insert(
            [
                'staff_id'          => 4,
                'name'              => 'おうち安心定食(リアル教室)',
                'price'             => 5000,
            ]
        );

    }
}
