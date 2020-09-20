<?php

use Illuminate\Database\Seeder;

class CourseCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'starter-washoku-real',
                'category'      => 'スターター(リアル教室)',
                'style'         => '和食'
            ]
        );
        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'starter-youshoku-real',
                'category'      => 'スターター(リアル教室)',
                'style'         => '洋食'
            ]
        );
        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'starter-chouka-real',
                'category'      => 'スターター(リアル教室)',
                'style'         => '中華'
            ]
        );
        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'basic-washoku-real',
                'category'      => '基本料理(リアル教室)',
                'style'         => '和食'
            ]
        );
        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'basic-youshoku-real',
                'category'      => '基本調理(リアル教室)',
                'style'         => '洋食'
            ]
        );
        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'basic-chouka-real',
                'category'      => '基本料理(リアル教室)',
                'style'         => '中華'
            ]
        );

        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'home-real',
                'category'      => '家庭料理(リアル教室)',
                'style'         => ''
            ]
        );

        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'fish-real',
                'category'      => '魚を捌く料理(リアル教室)',
                'style'         => ''
            ]
        );

        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'variety-real',
                'category'      => 'バラエティ(リアル教室)',
                'style'         => ''
            ]
        );

        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'cake-real',
                'category'      => 'パン・お菓子(リアル教室)',
                'style'         => ''
            ]
        );

        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'bread-real',
                'category'      => '手ごねパンとヘルシースイーツ(リアル教室)',
                'style'         => ''
            ]
        );
        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'regular-real',
                'category'      => 'おうち安心定食(リアル教室)',
                'style'         => ''
            ]
        );
        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'natural-real',
                'category'      => 'ナチュラル(リアル教室)',
                'style'         => ''
            ]
        );

        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'medical-real',
                'category'      => '美味しいおうち薬膳(リアル教室)',
                'style'         => ''
            ]
        );

        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'japanese-real',
                'category'      => '日本料理(リアル教室)',
                'style'         => ''
            ]
        );

        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'starter-washoku-online',
                'category'      => 'スターター(オンライン)',
                'style'         => '和食'
            ]
        );
        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'starter-youshoku-online',
                'category'      => 'スターター(オンライン)',
                'style'         => '洋食'
            ]
        );
        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'starter-chouka-online',
                'category'      => 'スターター(オンライン)',
                'style'         => '中華'
            ]
        );
        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'basic-washoku-online',
                'category'      => '基本料理(オンライン)',
                'style'         => '和食'
            ]
        );
        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'basic-youshoku-online',
                'category'      => '基本調理(オンライン)',
                'style'         => '洋食'
            ]
        );
        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'basic-chouka-online',
                'category'      => '基本料理(オンライン)',
                'style'         => '中華'
            ]
        );

        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'home-online',
                'category'      => '家庭料理(オンライン)',
                'style'         => ''
            ]
        );

        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'fish-online',
                'category'      => '魚を捌く料理(オンライン)',
                'style'         => ''
            ]
        );

        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'variety-online',
                'category'      => 'バラエティ(オンライン)',
                'style'         => ''
            ]
        );

        DB::table('course_categories')->insert(
            [
                'serach_index'  => 'other',
                'category'      => 'その他',
                'style'         => ''
            ]
        );
    }
}
