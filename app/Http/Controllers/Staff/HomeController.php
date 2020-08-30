<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Course;
use App\Models\Room;
use App\Models\Zoom;
use Auth;
use Carbon\Carbon;
use App\Models\AdminMessage;
use Session;

class HomeController extends Controller
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
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function index()
    {
        Session::forget('status');
        Session::forget('success');
        $staff = Auth::user();

        $admin_messages = AdminMessage::where('staff_id',$staff->id)
        ->where('direction','to_staff')
        ->where('expired_at','>',Carbon::now())
        ->get();


        $room = Room::where('staff_id', $staff->id)->first();
        if (is_null($room))
        {
            $room_count = 0;
        }
        else
        {
            $room_count = $room->count();
        }

        $course = Course::where('staff_id', $staff->id)->first();
        if (is_null($course))
        {
            $course_count = 0;
        }
        else
        {
            $course_count = $course->count();
        }

        // 現在の日時
        $now = Carbon::now()->toDateTimeString();
        $class_reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
            ->join('staff', 'schedules.staff_id', '=', 'staff.id')
            ->join('users', 'reservations.user_id', '=', 'users.id')
            ->join('courses', 'schedules.course_id', '=', 'courses.id')
            ->join('rooms', 'staff.id', '=', 'rooms.staff_id')
            ->where('schedules.staff_id','=',$staff->id)
            ->where('schedules.is_zoom','=',false)
            ->where('schedules.start','>=',$now)
            ->orderBy('schedules.start')
            ->get( [
                'reservations.id as id',
                'reservations.is_contract as is_contract',
                'reservations.is_pointpay as is_pointpay',
                'users.id as user_id',
                'users.name as user_name',
                'users.deleted_at as user_deleted_at',
                'courses.name as course_name',
                'courses.price as course_price',
                'schedules.start as start'
            ]);
      

        $zoom_reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
            ->join('staff', 'schedules.staff_id', '=', 'staff.id')
            ->join('users', 'reservations.user_id', '=', 'users.id')
            ->join('courses', 'schedules.course_id', '=', 'courses.id')
            ->join('zooms', 'staff.id', '=', 'zooms.staff_id')
            ->where('schedules.staff_id','=',$staff->id)
            ->where('schedules.is_zoom','=',true)
            ->where('schedules.start','>=',$now)
            ->orderBy('schedules.start')
            ->get( [
                    'reservations.id as id',
                    'reservations.is_contract as is_contract',
                    'reservations.is_pointpay as is_pointpay',
                    'zooms.name as zoom_name',
                    'courses.name as course_name',
                    'users.name as user_name',
                    'users.deleted_at as user_deleted_at',
                    'courses.price as course_price',
                    'schedules.start as start'
                ]);

        return view('staff.home')->with([
                        'admin_messages'     => $admin_messages,
                        'staff'              => $staff,
                        "room_count"        => $room_count, 
                        "course_count"      => $course_count, 
                        "class_reservations" => $class_reservations, 
                        "zoom_reservations"  => $zoom_reservations
                    ]);
    }

}