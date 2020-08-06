<?php

use Illuminate\Database\Seeder;

class PaymentDescriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_descriptions')->insert(
            [
                'name' => '入金'
            ]
        );
        DB::table('payment_descriptions')->insert(
            [
                'name' => '訂正'
            ]
        );
        DB::table('payment_descriptions')->insert(
            [
                'name' => 'ポイント還元'
            ]
        );
    }
}
