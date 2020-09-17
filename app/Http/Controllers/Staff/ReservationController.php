<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Zoom;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreZoom;
use App\Models\Course;
use App\Models\Admin;
use App\Exports\Export;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClassRoomReservationUserEmail;
use App\Mail\ClassRoomReservationStaffEmail;

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
        if (is_null($room)) {
            $room_count = 0;
        } else {
            $room_count = $room->count();
        }

        $course = Course::where('staff_id', $staff->id)->first();
        if (is_null($course)) {
            $course_count = 0;
        } else {
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
            ->where('schedules.staff_id', '=', $staff->id)
            ->where('schedules.is_zoom', '=', false)
//            ->whereNull('users.deleted_at')         
            ->whereBetween('schedules.start', [$now_first_month_day, $now_last_month_day])
            ->orderBy('schedules.start')
            ->get([
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
            ->where('schedules.staff_id', '=', $staff->id)
            ->where('schedules.is_zoom', '=', true)
//            ->whereNull('users.deleted_at')
            ->whereBetween('schedules.start', [$now_first_month_day, $now_last_month_day])
            ->orderBy('schedules.start')
            ->get([
                'reservations.id as id',
                'reservations.is_contract as is_contract',
                'reservations.is_pointpay as is_pointpay',
                'zooms.name as zoom_name',
                'courses.name as course_name',
                'users.name as user_name',
                'users.id as user_id',
                'users.deleted_at as user_deleted_at',
                'courses.price as price',
                'schedules.start as start'
            ]);

        return view('staff.reservation.index')->with([
            "room_count"        => $room_count,
            "course_count"      => $course_count,
            'previous_first_month_day' => $previous_first_month_day,
            'now_first_month_day' => $now_first_month_day,
            'next_first_month_day' => $next_first_month_day,
            'class_reservations' => $class_reservations,
            'zoom_reservations' => $zoom_reservations
        ]);
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
        if (is_null($room)) {
            $room_count = 0;
        } else {
            $room_count = $room->count();
        }

        $course = Course::where('staff_id', $staff->id)->first();
        if (is_null($course)) {
            $course_count = 0;
        } else {
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
            ->where('schedules.staff_id', '=', $staff->id)
            ->where('schedules.is_zoom', '=', false)
//            ->whereNull('users.deleted_at')
            ->whereBetween('schedules.start', [$now_first_month_day, $now_last_month_day])
            ->orderBy('schedules.start')
            ->get([
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
            ->where('schedules.staff_id', '=', $staff->id)
            ->where('schedules.is_zoom', '=', true)
 //           ->whereNull('users.deleted_at')
            ->whereBetween('schedules.start', [$now_first_month_day, $now_last_month_day])
            ->orderBy('schedules.start')
            ->get([
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

        return view('staff.reservation.index')->with([
            "room_count"        => $room_count,
            "course_count"      => $course_count,
            'previous_first_month_day' => $previous_first_month_day,
            'now_first_month_day' => $now_first_month_day,
            'next_first_month_day' => $next_first_month_day,
            'class_reservations' => $class_reservations,
            'zoom_reservations' => $zoom_reservations
        ]);
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

        $reservation = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
            ->join('staff', 'schedules.staff_id', '=', 'staff.id')
            ->join('users', 'reservations.user_id', '=', 'users.id')
            ->join('courses', 'schedules.course_id', '=', 'courses.id')
            ->join('rooms', 'staff.id', '=', 'rooms.staff_id')
            ->where('reservations.id', '=', $id)
            ->whereNull('users.deleted_at')     // OK!!
            ->get([
                'reservations.id as id',
                'reservations.is_contract as is_contract',
                'reservations.is_pointpay as is_pointpay',
                'users.id as user_id',
                'users.name as user_name',
                'users.email as user_email',
                'users.zip_code as user_zip_code',
                'users.pref as user_pref',
                'users.address as user_address',
                'users.tel as user_tel',
                'rooms.name as room_name',
                'rooms.address as room_address',
                'staff.id as staff_id',
                'staff.name as staff_name',
                'staff.email as staff_email',
                'courses.name as course_name',
                'courses.price as course_price',
                'schedules.start as start'
            ])->first();

        $mail_classification = "kakutei";
        $mail_title = "【予約確定】" . $reservation->course_name . "(" . date('Y年m月d日 H時i分', strtotime($reservation->start)) . ")の予約を確定しました。";
        $mail_data = [
            'reservation_id'    => $reservation->id,
            'course_name'       => $reservation->course_name,
            'user_name'         => $reservation->user_name,
            'user_id'           => $reservation->user_id,
            'user_email'        => $reservation->user_email,
            'user_address'      => "〒" . $reservation->user_zip_code . " " . $reservation->user_pref . $reservation->user_address,
            'user_tel'          => $reservation->user_tel,
            'staff_name'        => $reservation->staff_name,
            'room_name'         => $reservation->room_name,
            'room_address'      => $reservation->room_address,
            'price'             => number_format($reservation->course_price) . "円",
            'tax'               => number_format($reservation->course_price * 0.1) . "円",
            'tax_price'         => number_format($reservation->course_price * 1.1) . "円",
            'start'             => date('Y年m月d日 H時i分', strtotime($reservation->start))
        ];

        /* 生徒にメールを送信 */
        Mail::to($reservation->user_email)->send(new ClassRoomReservationUserEmail($mail_classification, $mail_title, $mail_data));

        /* 先生と管理者()にメールを送信 */
        Mail::to($reservation->staff_email)->cc(Admin::find(1)->email)->send(new ClassRoomReservationStaffEmail($mail_classification, $mail_title, $mail_data));


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
            ->where('schedules.staff_id', '=', $staff->id)
            ->where('schedules.is_zoom', '=', false)
//            ->whereNull('users.deleted_at')
            ->whereBetween('schedules.start', [$now_first_month_day, $now_last_month_day])
            ->orderBy('schedules.start')
            ->get([
                'reservations.id as id',
                'reservations.is_contract as is_contract',
                'reservations.is_pointpay as is_pointpay',
                'users.id as user_id',
                'users.name as user_name',
                'users.deleted_at as user_deleted_at',
                'courses.name as course_name',
                'courses.price as course_price',
                'schedules.start as start',
                'schedules.start as end'
            ]);


        $view = \view('staff.reservation.export_class')->with(['reservations' => $reservations]);

        $export_name = date('Y-m', strtotime($id)) . "_" . $staff->room->name . "の予約状況.xlsx";
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
            ->where('schedules.staff_id', '=', $staff->id)
            ->where('schedules.is_zoom', '=', true)
//            ->whereNull('users.deleted_at')
            ->whereBetween('schedules.start', [$now_first_month_day, $now_last_month_day])
            ->orderBy('schedules.start')
            ->get([
                'reservations.id as id',
                'reservations.is_contract as is_contract',
                'reservations.is_pointpay as is_pointpay',
                'users.id as user_id',
                'users.name as user_name',
                'users.deleted_at as user_deleted_at',
                'courses.name as course_name',
                'courses.price as course_price',
                'schedules.start as start',
                'schedules.start as end'
            ]);


        $view = \view('staff.reservation.export_zoom')->with(['reservations' => $reservations]);

        $export_name = date('Y-m', strtotime($id)) . "_" . $staff->zoom->name . "の予約状況.xlsx";
        return \Excel::download(new Export($view), $export_name);
    }
}
