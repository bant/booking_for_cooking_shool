<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Admin;
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

        if (!is_null($request->user_id)) {
            $users = User::where('id', $request->user_id)->get();
        } elseif (!is_null($request->name)) {
            $users = User::where('name', 'like', "%$request->name%")->get();
        } elseif (!is_null($request->address)) {
            $users = User::where('address', 'like', "%$request->address%")->get();
        }

        if (!is_null($users)) {
            if ($users->count() == 0) {
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
        $messages = UserStaffMessage::where('staff_id', $staff->id)
                                    ->where('dirction', 'to_staff')
                                    ->where('expired_at', '>', Carbon::now())
                                    ->get();

        return view('staff.message.user_list')->with(["messages"=> $messages]);
    }

    /**
     *  一括メッセージの作成
     */
    public function class_user_edit()
    {
        return view('staff.message.class_user_edit');
    }

    /**
     *  一括メッセージの送信
     */
    public function classuser_send(Request $request)
    {
        $staff = Auth::user();

        $class_reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
        ->join('staff', 'schedules.staff_id', '=', 'staff.id')
        ->join('users', 'reservations.user_id', '=', 'users.id')
        ->where('schedules.staff_id', '=', $staff->id)
        ->where('schedules.is_zoom', '=', false)
        ->whereNull('users.deleted_at')
        ->orderBy('schedules.start')
        ->get([
                'reservations.id as id',
                'users.id as user_id',
                'users.name as user_name',
            ]);
            
        foreach ($class_reservations as $class_reservation) {
            /* メッセージテープルに記録 */
            $message = new StaffMessage();
            $message->direction = 'to_user';
            $message->staff_id = $staff->id;
            $message->user_id = $class_reservation->user_id;
            $message->message = $request->message;
            $message->expired_at = Carbon::now()->addDay(7);  // 期限は一週間
            $message->save();
        }
        
        return back()->with('success', $class_reservations->count().'件のメッセージを送信');
    }


    /**
     *  管理者へのメッセージの作成
     */
    public function admin_edit()
    {
        return view('staff.message.admin_edit');
    }

    /**
     *  管理者へメッセージの送信
     */
    public function admin_send(Request $request)
    {
        $staff = Auth::user();

        /* メッセージテープルに記録 */
        $message = new StaffMessage();
        $message->direction = 'to_admin';
        $message->staff_id = $staff->id;
//        $message->admin_id = Admin::find(1)->id;
        $message->admin_id = 1;
        $message->message = $request->message;
        $message->expired_at = Carbon::now()->addDay(7);  // 期限は一週間
        $message->save();

        return back()->with('success', '1件のメッセージを送信');
    }


    /**
     *
     */
    public function admin_list()
    {
        $staff = Auth::user();
        $messages = UserAdminMessage::where('staff_id', $staff->id)
                                    ->where('dirction', 'to_staff')
                                    ->where('expired_at', '>', Carbon::now())
                                    ->get();

        return view('staff.message.admin_index')->with(["messages" => $messages]);
    }

    public function admin_delete($id)
    {
        AdminMessage::where('id', $id)->delete();
        return back()->with('success', 'メッセージを削除しました。');
    }
}
