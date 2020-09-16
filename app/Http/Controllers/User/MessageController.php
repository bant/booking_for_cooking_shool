<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserfMessage;
use App\Models\StaffMessage;
use App\Models\AdminMessage;
use App\Models\UserMessage;
use App\Models\Reservation;
use App\Models\WaitListReservation;
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
        $this->middleware('auth:user');
    }

    /**
     * 
     * 
     */
    public function send_cancel_message($id)
    {
        $user = Auth::user();
        $reservation = Reservation::find($id);

        $check = UserMessage::where('outline','booking_cancel')
                            ->where('direction','to_staff_and_admin')
                            ->where('reservation_id',$reservation->id)
                            ->get();
        /* メッセージテープルに記録 */
        if ($check->count() == 0)
        {
            $message = new UserMessage();
            $message->outline = 'booking_cancel';
            $message->direction = 'to_staff_and_admin';
            $message->reservation_id = $reservation->id;
            $message->wait_list_reservation_id = 0;
            $message->staff_id = $reservation->schedule->staff_id;
            $message->user_id = $user->id;
            $message->admin_id = 1;
            $message->message = "予約取り消し依頼がありました";
            $message->expired_at = Carbon::now()->addDay(28);  // 期限は4週間
            $message->save();
            return back()->with('success', '予約取り消し依頼のメッセージを送信しました。取り消しまで、しばらくお待ちください。');
        }
        else
       {
            return back()->with('success', '予約取り消し依頼のメッセージは送信済みです。取り消しまで、しばらくお待ちください。');
       } 
    }

    /**
     * 
     * 
     */
    public function send_wait_list_cancel_message($id)
    {
        $user = Auth::user();
        $wait_list_reservation = WaitListReservation::find($id);

        $check = UserMessage::where('outline','wait_list_cancel')
            ->where('direction','to_staff_and_admin')
            ->where('reservation_id',$wait_list_reservation->id)
            ->get();
       
        if ($check->count() == 0)
        {
            /* メッセージテープルに記録 */
            $message = new UserMessage();
            $message->outline = 'wait_list_cancel';
            $message->direction = 'to_staff_and_admin';
            $message->reservation_id = 0;
            $message->wait_list_reservation_id = $wait_list_reservation->id;
            $message->staff_id = $wait_list_reservation->schedule->staff_id;
            $message->user_id = $user->id;
            $message->admin_id = 1;
            $message->message = "キャンセル待ち取り消し依頼がありました。";
            $message->expired_at = Carbon::now()->addDay(28);  // 期限は4週間
            $message->save();
        
            return back()->with('success', 'キャンセル待ち取り消し依頼のメッセージを送信しました。取り消しまで、しばらくお待ちください。');
        }
        else
        {
            return back()->with('success', 'キャンセル待ち取り消し依頼のメッセージは送信済みです。取り消しまで、しばらくお待ちください。');
        }
    }

    /**
     * 
     * 
     */
    public function admin_delete($id)
    {
        AdminMessage::where('id',$id)->delete();
        return back()->with('success', 'メッセージを削除しました。');
    }

    /**
     * 
     * 
     */
    public function staff_delete($id)
    {
        StaffMessage::where('id',$id)->delete();
        return back()->with('success', 'メッセージを削除しました。');
    }
}
