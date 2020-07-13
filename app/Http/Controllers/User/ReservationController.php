<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Schedule;
use Auth;

class ReservationController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
            ->join('staff', 'schedules.staff_id', '=', 'staff.id')
            ->where('user_id','=',$user->id)
            ->orderBy('schedules.start')
            ->get();

        $user = Auth::user();
        $reservations = Reservation::where('user_id', $user->id)->get();

        return view('user.reservation.index')->with('reservations', $reservations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $schedule = Schedule::find($request->id);

        return view('user.reservation.create')->with('schedule', $schedule);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $reservations = Reservation::where('user_id','=',$user->id)
            ->where('schedule_id','=',$request->schedule_id)->get();

        $schedule = Schedule::find($request->schedule_id);

        if($reservations->count())
        {
            return  redirect("/user/ClassroomSchedule/calendar/$schedule->staff_id");
        }
        else 
        {
            $reservation = new Reservation();
            $reservation->user_id = $user->id;
            $reservation->schedule_id = $request->schedule_id;
    
            $reservation->save();

            return  redirect("/user/ClassroomSchedule/calendar/$schedule->staff_id");
        }
    }

    /**
     * 各先生の予定
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();

        $reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
            ->join('staff', 'schedules.staff_id', '=', 'staff.id')
            ->where('user_id','=',$user->id)
            ->orderBy('schedules.start')
            ->get();

        return view('user.reservation.home')->with('reservations', $reservations);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function classroom($id)
    {
        $user = Auth::user();
        $reservations = Reservation::where('user_id', $user->id)->get();

        return view('user.reservation.home')->with('reservations', $reservations);
    }
}
