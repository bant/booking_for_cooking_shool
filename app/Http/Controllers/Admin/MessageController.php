<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\Models\Schedule;
use App\Models\Reservation;
use App\Models\AdminMessage;
use App\Models\StaffMessage;
use Illuminate\Support\Facades\Auth;
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
    public function reservation_id_list()
    {
        $reservations = Reservation::where('is_contract',false)->orderBy('created_at', 'desc')->get();
        return view('admin.message.reservation_id_list')->with(["reservations" => $reservations]);
    }

    /**
     * 
     */
    public function reservation_id_search(Request $request)
    {
        if (!is_null($request->reservation_id))
        {
            $reservations = Reservation::where('id',$request->reservation_id)->where('is_contract',false)->orderBy('created_at', 'desc')->get();
        }
        else
        {
            $reservations = Reservation::where('is_contract',false)->orderBy('created_at', 'desc')->get();
        }
        return view('admin.message.reservation_id_list')->with(["reservations" => $reservations]);
    }


    /**
     * 
     */
    public function reservation_user_list()
    {
        $reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
            ->join('staff', 'schedules.staff_id', '=', 'staff.id')
            ->join('users', 'reservations.user_id', '=', 'users.id')
            ->join('courses', 'schedules.course_id', '=', 'courses.id')
            ->join('rooms', 'staff.id', '=', 'rooms.staff_id')
            ->join('zooms', 'staff.id', '=', 'zooms.staff_id')
            ->where('reservations.is_contract','=',false)
            ->whereNull('users.deleted_at')
            ->orderBy('reservations.created_at', 'desc')
            ->get( [
                'reservations.id as id',
                'reservations.is_contract as is_contract',
                'reservations.is_pointpay as is_pointpay',
                'users.id as user_id',
                'users.name as user_name',
                'users.pref as user_pref',
                'users.address as user_address',
                'rooms.name as room_name',
                'zooms.name as zoom_name',
                'courses.name as course_name',
                'staff.id as staff_id',
                'staff.name as staff_name',
                'courses.price as course_price',
                'schedules.is_zoom as is_zoom',
                'schedules.start as start'
            ]);

        return view('admin.message.reservation_user_list')->with(["reservations" => $reservations]);
    }

    /**
     * 
     */
    public function reservation_user_search(Request $request)
    {
        $sql = $reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
            ->join('staff', 'schedules.staff_id', '=', 'staff.id')
            ->join('users', 'reservations.user_id', '=', 'users.id')
            ->join('courses', 'schedules.course_id', '=', 'courses.id')
            ->join('rooms', 'staff.id', '=', 'rooms.staff_id')
            ->join('zooms', 'staff.id', '=', 'zooms.staff_id')
            ->where('reservations.is_contract','=',false)
            ->whereNull('users.deleted_at');

        if (!is_null($request->name))
        {
            $sql = $sql->where('users.name', 'like', "%$request->name%");
        }
        else if (!is_null($request->kana))
        {
            $sql = $sql->where('users.kana', 'like', "%$request->kana%");
        }

        $reservations = $sql
            ->orderBy('reservations.created_at', 'desc')
            ->get( [
                'reservations.id as id',
                'reservations.is_contract as is_contract',
                'reservations.is_pointpay as is_pointpay',
                'users.id as user_id',
                'users.name as user_name',
                'users.pref as user_pref',
                'users.address as user_address',
                'rooms.name as room_name',
                'zooms.name as zoom_name',
                'courses.name as course_name',
                'staff.id as staff_id',
                'staff.name as staff_name',
                'courses.price as course_price',
                'schedules.is_zoom as is_zoom',
                'schedules.start as start'
        ]);

        return view('admin.message.reservation_user_list')->with(["reservations" => $reservations]);
    }

    /**
     * 
     * 
     */
    public function edit_to_user_message($id)
    {
        $reservation = Reservation::find($id);
        return view('admin.message.edit_to_user_message')->with(["reservation" => $reservation]);
    }

    /**
     * 
     * 
     */
    public function edit_to_staff_message($id)
    {
        $reservation = Reservation::find($id);
        return view('admin.message.edit_to_staff_message')->with(["reservation" => $reservation]);
    }

    /**
     * (Request $request)
     */
    public function send_to_staff_message(Request $request)
    {
        /* メッセージテープルに記録 */
        $message = new AdminMessage;
        $message->direction = 'to_staff';
        $message->admin_id =  Auth::user()->id;
        $message->reservation_id = $request->reservation_id;
        $message->staff_id = $request->staff_id;
        $message->message = $request->message;
        $message->expired_at = Carbon::now()->addDay(7);  // 期限は一週間
        $message->save();

        return back()->with('success', $request->staff_name.'先生へメッセージを送信しました');
    }

    /**
     * 
     */
    public function delete_staff_message($id)
    {
        StaffMessage::find($id)->delete();
        return back()->with('success', 'メッセージを削除しました');
    }

    /**
     * (Request $request)
     */
    public function send_to_user_message(Request $request)
    {
        /* メッセージテープルに記録 */
        $message = new AdminMessage;
        $message->direction = 'to_user';
        $message->admin_id =  Auth::user()->id;
        $message->reservation_id = $request->reservation_id;
        $message->user_id = $request->user_id;
        $message->message = $request->message;
        $message->expired_at = Carbon::now()->addDay(7);  // 期限は一週間
        $message->save();

        return back()->with('success', $request->user_name.'さんへメッセージを送信しました');
    }
}
