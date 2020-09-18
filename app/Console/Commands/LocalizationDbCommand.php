<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Str;
use Carbon\Carbon;

class LocalizationDbCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:localization_db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::table('users')->where('email', 'info@kuritacooking.com')->update(
            [
                'email'     => 'info2@cooking.sumomo.ne.jp',
                'password'  => Hash::make('pass0123456789'),
            ]
        );

        DB::table('staff')->where('email', 'toshiko@kuritacooking.com')->update(
            [
                'email'     => 'staff1@cooking.sumomo.ne.jp',
                'password'  => Hash::make('pass0123456789'),
            ]
        );

        DB::table('staff')->where('email', 'tomo@kuritacooking.com')->update(
            [
                'email'     => 'staff2@cooking.sumomo.ne.jp',
                'password'  => Hash::make('pass0123456789'),
            ]
        );
        
        DB::table('staff')->where('email', 'kei@kuritacooking.com')->update(
            [
                'email'     => 'staff3@cooking.sumomo.ne.jp',
                'password'  => Hash::make('pass0123456789'),
            ]
        );
        
        DB::table('staff')->where('email', 'hama@kuritacooking.com')->update(
            [
                'email'     => 'staff4@cooking.sumomo.ne.jp',
                'password'  => Hash::make('pass0123456789'),
            ]
        );

        DB::table('admins')->where('email', 'admin@kuritacooking.com')->update(
            [
                'email'     => 'admin1@cooking.sumomo.ne.jp',
                'password'  => Hash::make('pass0123456789'),
            ]
        );
    }
}
