<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function index()
    {
        // 現在の日時
        $now = Carbon::now();

        $count = 0;

        Carbon::useMonthsOverflow(false); // デフォルトはtrue

        $count_datas = array();
        for ($i = 11; $i >= 0; $i--) {
            $first_month_day = Carbon::now()->day(1)->subMonths($i)->startOfMonth()->toDateString();
            $last_month_day = Carbon::now()->day(1)->subMonths($i)->endOfMonth()->toDateString();
            $add_count = User::whereBetween('created_at', [$first_month_day, $last_month_day])->get()->count();
            $stop_count = User::onlyTrashed()->whereNotNull('id')->whereBetween('deleted_at', [$first_month_day, $last_month_day])->get()->count();
            $all_count = User::where('created_at', '<', $last_month_day)->get()->count();
            array_push($count_datas,['first_month_day'=>$first_month_day, 'add_count' => $add_count, 'stop_count' => $stop_count, 'all_count' => $all_count ]);
        }

        return view('admin.home')->with(['count_datas'=>$count_datas]);;
    }

}