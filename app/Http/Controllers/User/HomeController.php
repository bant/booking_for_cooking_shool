<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Schedule;
use App\Models\Room;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function index()
    {
        $user = Auth::user();

        $reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
            ->join('staff', 'schedules.owner_id', '=', 'staff.id')
            ->where('user_id','=',$user->id)
            ->orderBy('schedules.start')
            ->get();

/*

["staff.name as owner_name"]

        $reservations = Reservation::with('schedules')
                ->where('user_id', '=', $user->id)
   
                ->get();
*/
  //      dd($reservations->each->schedules);

        $rooms = Room::all();

        foreach ($rooms as $room) {
            dd($room->name);
        }

//        return view('user.home')->with('reservations', $reservations);

        return view('user.home')->with(["reservations" => $reservations, "rooms" => $rooms ]);
    }
}