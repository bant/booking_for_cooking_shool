<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Schedule;
use App\Models\Room;
use App\Models\Zoom;
use App\Models\AdminMessage;
use App\Models\StaffMessage;
use Auth;
use Session;
use Carbon\Carbon;

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
        Session::forget('status');
        Session::forget('success');
        $user = Auth::user();
        $rooms = Room::all();
        $zooms = Zoom::all();

        if (!$user->checkProfile()) {
            return view('user.profile_error')->with(['rooms' => $rooms, 'zooms' => $zooms]);
        } else {
            $admin_messages = AdminMessage::where('user_id', $user->id)
                            ->where('direction', 'to_user')
                            ->where('expired_at', '>', Carbon::now())
                            ->get();
    
            $staff_messages = StaffMessage::where('user_id', $user->id)
                            ->where('direction', 'to_user')
                            ->where('expired_at', '>', Carbon::now())
                            ->get();
            
    
            $classroom_reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
                ->join('staff', 'schedules.staff_id', '=', 'staff.id')
                ->join('courses', 'schedules.course_id', '=', 'courses.id')
                ->join('rooms', 'staff.id', '=', 'rooms.staff_id')
                ->where('reservations.user_id', '=', $user->id)
                ->where('schedules.is_zoom', '=', false)
                ->where('start', '>', Carbon::now())
                ->orderBy('schedules.start')
                ->get([
                    'reservations.id as id',
                    'reservations.is_contract as is_contract',
                    'reservations.is_pointpay as is_pointpay',
                    'rooms.name as room_name',
                    'courses.name as course_name',
                    'staff.name as staff_name',
                    'courses.price as course_price',
                    'schedules.start as start'
                ]);

            $zoom_reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
                ->join('staff', 'schedules.staff_id', '=', 'staff.id')
                ->join('courses', 'schedules.course_id', '=', 'courses.id')
                ->join('rooms', 'staff.id', '=', 'rooms.staff_id')
                ->where('reservations.user_id', '=', $user->id)
                ->where('schedules.is_zoom', '=', true)
                ->where('start', '>', Carbon::now())
                ->orderBy('schedules.start')
                ->get([
                    'reservations.id as id',
                    'reservations.is_contract as is_contract',
                    'reservations.is_pointpay as is_pointpay',
                    'rooms.name as room_name',
                    'courses.name as course_name',
                    'staff.name as staff_name',
                    'courses.price as course_price',
                    'schedules.start as start'
                ]);

            return view('user.home')->with([
                        'admin_messages'            => $admin_messages,
                        'staff_messages'            => $staff_messages,
                        'rooms'                     => $rooms,
                        'zooms'                     => $zooms,
                        'classroom_reservations'    => $classroom_reservations,
                        'zoom_reservations'         => $zoom_reservations
                    ]);
        }
    }
}
