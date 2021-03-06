<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(StaffTableSeeder::class);
        $this->call(RoomsTableSeeder::class);
        $this->call(CoursesTableSeeder::class);
        $this->call(PaymentDescriptionsTableSeeder::class);
        $this->call(CourseCategoriesTableSeeder::class);
    }
}
