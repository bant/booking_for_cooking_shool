<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Carbon\Carbon;

use App\Models\User;
use App\Models\StaffMessage;
use App\Models\AdminMessage;
use App\Models\Reservation;

class MessageController extends Controller
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
     * 
     */
    public function user_search(Request $request)
    {
        // 指定アイテムを削除
        $request->session()->forget('status');
        $request->session()->forget('success');

        $users = null;

        if (!is_null($request->user_id)) 
        {
            $users = User::where('id', $request->user_id)->get();
        }
        else if (!is_null($request->name))
        {
            $users = User::where('name', 'like', "%$request->name%")->get();
        }
        else if (!is_null($request->address))
        {
            $users = User::where('address', 'like', "%$request->address%")->get();
        }

        if (!is_null($users))
        {
            if ($users->count() == 0)
            {
                $users = null;
            }
        }
        /* ユーザ検索一覧ビュー表示 */
        return view('staff.message.user_search')->with(["users" => $users]);
    }

   


    /**
     * 
     */
    public function user_list()
    {
        $staff = Auth::user();
        $messages = UserStaffMessage::where('staff_id',$staff->id)
                                    ->where('dirction', 'to_staff')
                                    ->where('expired_at', '>' , Carbon::now())
                                    ->get();  

         return view('staff.message.user_list')->with(["messages"=> $messages]);
    }

    /**
     * 
     */
    public function user_edit()
    {
        return view('staff.message.user_edit');
    }


    public function classuser_send(Request $request)
    {
        $staff = Auth::user();

        $class_reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
        ->join('staff', 'schedules.staff_id', '=', 'staff.id')
        ->join('users', 'reservations.user_id', '=', 'users.id')
        ->where('schedules.staff_id','=',$staff->id)
        ->where('schedules.is_zoom','=',false)
        ->orderBy('schedules.start')
        ->get( [
                'reservations.id as id',
                'users.id as user_id',
                'users.name as user_name',
            ]);
            
        foreach($class_reservations as $class_reservation)
        {
            /* メッセージテープルに記録 */
            $staff_message = new StaffMessage();
            $staff_message->direction = 'ToUser';
            $staff_message->staff_id = $staff->id;
            $staff_message->user_id = $class_reservation->user_id;
            $staff_message->message = $request->message;
            $staff_message->expired_at = Carbon::now()->addDay(7);  // 期限は一週間
            $staff_message->save();
        }
        return back()->with('success', $class_reservations->count().'件のメッセージを送信');

    }


    /**
     * 
     */
    public function admin_list()
    {
        $staff = Auth::user();
        $messages = UserAdminMessage::where('staff_id',$staff->id)
                                    ->where('dirction', 'to_staff')
                                    ->where('expired_at', '>' , Carbon::now())
                                    ->get();  

        return view('staff.message.admin_index')->with([
                        "messages"        => $messages 
                    ]);
    }




}
