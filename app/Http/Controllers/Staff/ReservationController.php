<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Zoom;
use Auth;
use App\Http\Requests\StoreZoom;
use App\Models\Course;

use Carbon\Carbon;

class ReservationController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staff = Auth::user();
        
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

        $previous_first_month_day = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $now_first_month_day = Carbon::now()->startOfMonth()->toDateString();
        $now_last_month_day = Carbon::now()->endOfMonth()->toDateString();
        $next_first_month_day = Carbon::now()->addMonth()->startOfMonth()->toDateString();

        $class_reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
        ->join('staff', 'schedules.staff_id', '=', 'staff.id')
        ->join('users', 'reservations.user_id', '=', 'users.id')
        ->join('courses', 'schedules.course_id', '=', 'courses.id')
        ->join('rooms', 'staff.id', '=', 'rooms.staff_id')
        ->where('schedules.staff_id','=',$staff->id)
        ->where('schedules.is_zoom','=',false)
        ->whereBetween('schedules.start', [$now_first_month_day, $now_last_month_day])
        ->orderBy('schedules.start')
        ->get( [
                'reservations.id as id',
                'reservations.is_pointpay as is_pointpay',
                'users.id as user_id',
                'users.name as user_name',
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
            ->whereBetween('schedules.start', [$now_first_month_day, $now_last_month_day])
            ->orderBy('schedules.start')
            ->get( [
                    'reservations.id as id',
                    'reservations.is_pointpay as is_pointpay',
                    'zooms.name as zoom_name',
                    'courses.name as course_name',
                    'users.name as user_name',
                    'courses.price as course_price',
                    'schedules.start as start'
                ]);

        return view('staff.reservation.index')->with([
            "room_count"        => $room_count, 
            "course_count"      => $course_count, 
            'previous_first_month_day' => $previous_first_month_day,
            'now_first_month_day' => $now_first_month_day,
            'next_first_month_day' => $next_first_month_day,
            'class_reservations' => $class_reservations, 
            'zoom_reservations' => $zoom_reservations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $staff = Auth::user();

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

        $previous_first_month_day = Carbon::createFromTimestamp(strtotime($id)) 
                                    ->timezone(\Config::get('app.timezone'))->subMonth()->startOfMonth()->toDateString();
        $now_first_month_day = Carbon::createFromTimestamp(strtotime($id)) 
                                ->timezone(\Config::get('app.timezone'))->startOfMonth()->toDateString();
        $now_last_month_day = Carbon::createFromTimestamp(strtotime($id)) 
                                ->timezone(\Config::get('app.timezone'))->endOfMonth()->toDateString();
        $next_first_month_day = Carbon::createFromTimestamp(strtotime($id)) 
                                ->timezone(\Config::get('app.timezone'))->addMonth()->startOfMonth()->toDateString();

//        dd( $now_last_month_day);
        $class_reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
        ->join('staff', 'schedules.staff_id', '=', 'staff.id')
        ->join('users', 'reservations.user_id', '=', 'users.id')
        ->join('courses', 'schedules.course_id', '=', 'courses.id')
        ->join('rooms', 'staff.id', '=', 'rooms.staff_id')
        ->where('schedules.staff_id','=',$staff->id)
        ->where('schedules.is_zoom','=',false)
        ->whereBetween('schedules.start', [$now_first_month_day, $now_last_month_day])
        ->orderBy('schedules.start')
        ->get( [
                'reservations.id as id',
                'users.id as user_id',
                'users.name as user_name',
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
            ->whereBetween('schedules.start', [$now_first_month_day, $now_last_month_day])
            ->orderBy('schedules.start')
            ->get( [
                    'reservations.id as id',
                    'reservations.is_pointpay as is_pointpay',
                    'zooms.name as zoom_name',
                    'courses.name as course_name',
                    'users.name as user_name',
                    'courses.price as course_price',
                    'schedules.start as start'
                ]);

        return view('staff.reservation.index')->with([
            "room_count"        => $room_count, 
            "course_count"      => $course_count, 
            'previous_first_month_day' => $previous_first_month_day,
            'now_first_month_day' => $now_first_month_day,
            'next_first_month_day' => $next_first_month_day,
            'class_reservations' => $class_reservations, 
            'zoom_reservations' => $zoom_reservations]);
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
}
