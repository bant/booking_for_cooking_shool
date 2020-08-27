<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\Models\Schedule;
use App\Models\Reservation;
use App\Models\AdminMessage;
use Auth;
use Carbon\Carbon;

class MessageController extends Controller
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
     * 
     */
    public function staff_show()
    {
        /* ユーザ検索一覧ビュー表示 */
        return view('admin.message.staff_search')->with(["reservation" => null]);
    }

    /**
     * (Request $request)
     */
    public function staff_search(Request $request)
    {
        $reservation = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
        ->join('staff', 'schedules.staff_id', '=', 'staff.id')
        ->join('users', 'reservations.user_id', '=', 'users.id')
        ->join('courses', 'schedules.course_id', '=', 'courses.id')
        ->join('rooms', 'staff.id', '=', 'rooms.staff_id')
        ->where('reservations.id','=',$request->reservation_id)
        ->get( [
                'reservations.id as id',
                'reservations.is_contract as is_contract',
                'reservations.is_pointpay as is_pointpay',
                'users.id as user_id',
                'users.name as user_name',
                'users.pref as user_pref',
                'users.address as user_address',
                'rooms.name as room_name',
                'courses.name as course_name',
                'staff.id as staff_id',
                'staff.name as staff_name',
                'courses.price as course_price',
                'schedules.is_zoom as is_zoom',
                'schedules.start as start'
            ])->first();

        /* ユーザ検索一覧ビュー表示 */
        return view('admin.message.staff_search')->with(["reservation" => $reservation]);
    }



     /**
     * (Request $request)
     */
    public function send_to_staff_message(Request $request)
    {
        /* メッセージテープルに記録 */
        $message = new AdminMessage();
        $message->direction = 'ToStaff';
        $message->admin_id =  Auth::user()->id;
        $message->reservation_id = $request->reservation_id;
        $message->staff_id = $request->staff_id;
        $message->message = $request->message;
        $message->expired_at = Carbon::now()->addDay(7);  // 期限は一週間
        $message->save();

        return back()->with('success', $request->staff_name.'先生へメッセージを送信');
    }


    /**
     * 
     */
    public function user_show()
    {
        /* ユーザ検索一覧ビュー表示 */
        return view('admin.message.user_search')->with(["reservation" => null]);
    }

    /**
     * (Request $request)
     */
    public function user_search(Request $request)
    {
        $reservation = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
        ->join('staff', 'schedules.staff_id', '=', 'staff.id')
        ->join('users', 'reservations.user_id', '=', 'users.id')
        ->join('courses', 'schedules.course_id', '=', 'courses.id')
        ->join('rooms', 'staff.id', '=', 'rooms.staff_id')
        ->where('reservations.id','=',$request->reservation_id)
        ->get( [
                'reservations.id as id',
                'reservations.is_contract as is_contract',
                'reservations.is_pointpay as is_pointpay',
                'users.id as user_id',
                'users.name as user_name',
                'users.pref as user_pref',
                'users.address as user_address',
                'rooms.name as room_name',
                'courses.name as course_name',
                'staff.id as staff_id',
                'staff.name as staff_name',
                'courses.price as course_price',
                'schedules.is_zoom as is_zoom',
                'schedules.start as start'
            ])->first();

        /* ユーザ検索一覧ビュー表示 */
        return view('admin.message.user_search')->with(["reservation" => $reservation]);
    }


    /**
     * (Request $request)
     */
    public function send_to_user_message(Request $request)
    {
        /* メッセージテープルに記録 */
        $message = new AdminMessage();
        $message->direction = 'ToUser';
        $message->admin_id =  Auth::user()->id;
        $message->reservation_id = $request->reservation_id;
        $message->user_id = $request->user_id;
        $message->message = $request->message;
        $message->expired_at = Carbon::now()->addDay(7);  // 期限は一週間
        $message->save();

        return back()->with('success', $request->staff_name.'先生へメッセージを送信');
    }
}
