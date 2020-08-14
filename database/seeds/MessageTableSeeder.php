<?php

use Illuminate\Database\Seeder;

class MessageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_staff_messages')->insert([
            'dirction'  => 'to_user',
            'user_id'   => 1,
            'staff_id'  => 1,
            'message'    => '先生からのメッセージです',
        ]);
        DB::table('user_staff_messages')->insert([
            'dirction'  => 'to_staff',
            'user_id'   => 1,
            'staff_id'  => 1,
            'message'    => 'テストです',
        ]);
    }
}
