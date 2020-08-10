<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Zoom;
use Auth;
use App\Http\Requests\StoreZoom;
use App\Models\Course;

use App\Exports\Export;
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

        // 現在の日時
        $now = Carbon::now();

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
                'reservations.is_contract as is_contract',
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
                    'reservations.is_contract as is_contract',
                    'reservations.is_pointpay as is_pointpay',
                    'zooms.name as zoom_name',
                    'courses.name as course_name',
                    'users.name as user_name',
                    'users.id as user_id',
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
                'reservations.is_contract as is_contract',
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
                    'reservations.is_contract as is_contract',
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function is_contract_update($id)
    {
        Reservation::where('id', $id)->update(['is_contract' => true]);
        return back()->with('success', '本予約しました');
    }


    /**
     * 帳票のエクスポート
     */
    public function export_class($id)
    {
        $staff = Auth::user();

        $now_first_month_day = Carbon::createFromTimestamp(strtotime($id)) 
                                ->timezone(\Config::get('app.timezone'))->startOfMonth()->toDateString();
        $now_last_month_day = Carbon::createFromTimestamp(strtotime($id)) 
                                ->timezone(\Config::get('app.timezone'))->endOfMonth()->toDateString();

        $reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
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
                'reservations.is_contract as is_contract',
                'reservations.is_pointpay as is_pointpay',
                'users.id as user_id',
                'users.name as user_name',
                'courses.name as course_name',
                'courses.price as course_price',
                'schedules.start as start'
            ]); 


        $view = \view('staff.reservation.export_class')->with(['reservations' => $reservations]);
     
        $export_name = date('Y-m', strtotime($id)) . "_reservation_class.xlsx";
        return \Excel::download(new Export($view), $export_name);
    }

    /**
     * 帳票のエクスポート
     */
    public function export_zoom($id)
    {
        $staff = Auth::user();

        $now_first_month_day = Carbon::createFromTimestamp(strtotime($id)) 
                                ->timezone(\Config::get('app.timezone'))->startOfMonth()->toDateString();
        $now_last_month_day = Carbon::createFromTimestamp(strtotime($id)) 
                                ->timezone(\Config::get('app.timezone'))->endOfMonth()->toDateString();

        $reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
        ->join('staff', 'schedules.staff_id', '=', 'staff.id')
        ->join('users', 'reservations.user_id', '=', 'users.id')
        ->join('courses', 'schedules.course_id', '=', 'courses.id')
        ->join('rooms', 'staff.id', '=', 'rooms.staff_id')
        ->where('schedules.staff_id','=',$staff->id)
        ->where('schedules.is_zoom','=',true)
        ->whereBetween('schedules.start', [$now_first_month_day, $now_last_month_day])
        ->orderBy('schedules.start')
        ->get( [
                'reservations.id as id',
                'reservations.is_contract as is_contract',
                'reservations.is_pointpay as is_pointpay',
                'users.id as user_id',
                'users.name as user_name',
                'courses.name as course_name',
                'courses.price as course_price',
                'schedules.start as start'
            ]); 


        $view = \view('staff.reservation.export_zoom')->with(['reservations' => $reservations]);
     
        $export_name = date('Y-m', strtotime($id)) . "_reservation_zooms.xlsx";
        return \Excel::download(new Export($view), $export_name);
    }

}
