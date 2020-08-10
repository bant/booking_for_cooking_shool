<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Reservation;
use Auth;
use Carbon\Carbon;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:staff');
    }

    /**
     * 生徒の情報を取り出す
     *
     * @return \Illuminate\Http\Response
     */
    public function info($id)
    {
        $staff = Auth::user();
        $user = User::find($id);

        // 現在の日時
        $now = Carbon::now()->toDateTimeString();
        $class_reservation_times = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
            ->join('staff', 'schedules.staff_id', '=', 'staff.id')
            ->join('users', 'reservations.user_id', '=', 'users.id')
            ->where('reservations.user_id','=',$id)
            ->where('schedules.staff_id','=',$staff->id)
            ->where('schedules.is_zoom','=',false)
            ->where('schedules.start','<',$now)
            ->count();

        $zoom_reservation_times = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
            ->join('staff', 'schedules.staff_id', '=', 'staff.id')
            ->join('users', 'reservations.user_id', '=', 'users.id')
            ->where('reservations.user_id','=',$id)
            ->where('schedules.staff_id','=',$staff->id)
            ->where('schedules.is_zoom','=',true)
            ->where('schedules.start','<',$now)
            ->count();

        return view('staff.user.info')->with([
            'user' => $user, 
            'class_reservation_times' => $class_reservation_times, 
            'zoom_reservation_times' => $zoom_reservation_times 
        ]);

    }


}
