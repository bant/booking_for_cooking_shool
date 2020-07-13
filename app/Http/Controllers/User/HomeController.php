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

        $rooms = Room::all();

        $classroom_reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
            ->join('staff', 'schedules.staff_id', '=', 'staff.id')
            ->join('courses', 'schedules.course_id', '=', 'courses.id')
            ->where('reservations.user_id','=',$user->id)
            ->where('schedules.is_zoom', '=', false)
            ->orderBy('schedules.start')
            ->get();
//            ->get( ['schedules.id as schedules_id'] );

//        dd($classroom_reservations);

        $zoom_reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
            ->join('staff', 'schedules.staff_id', '=', 'staff.id')
            ->where('reservations.user_id','=',$user->id)
            ->where('schedules.is_zoom', '=', true)
            ->orderBy('schedules.start')
            ->get();

        return view('user.home')->with([
                    'rooms'                     => $rooms,
                    'classroom_reservations'    => $classroom_reservations, 
                    'zoom_reservations'         => $zoom_reservations 
                ]);
    }
}