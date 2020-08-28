<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Auth;
use App\Models\StaffMessage;

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
        $admin = Auth::user();

        $staff_messages = StaffMessage::where('admin_id',$admin->id)
            ->where('direction','to_admin')
            ->where('expired_at','>',Carbon::now())
            ->get();

            return view('admin.home')->with(['staff_messages'=>$staff_messages]);;
    }
}