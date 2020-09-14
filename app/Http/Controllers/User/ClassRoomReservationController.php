<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\WaitListReservation;
use App\Models\Schedule;
use App\Models\Course;
use App\Models\Admin;
use App\Models\Staff;
use App\Models\User;
use App\Models\AdminMessage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClassRoomReservationUserEmail;
use App\Mail\ClassRoomReservationStaffEmail;
use App\Mail\ClassRoomCancelUserEmail;
use App\Mail\ClassRoomCancelStaffEmail;
use Auth;
use Carbon\Carbon;

class ClassRoomReservationController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user->checkProfile()) 
        {
            return view('user.profile_error');
        } 
        else 
        {
            /*教室情報を */
            $room = Room::all()->first();
            if (!is_null($room)) 
            {
                return  redirect()->route('user.classroom_reservation.calendar', ['id' => $room->staff_id]);
            } 
            else 
            {
                return  view('user.classroom_reservation.index');
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $schedule = Schedule::find($id);
        return view('user.classroom_reservation.create')->with(["schedule" => $schedule]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $point  = $user->point;
        $schedule = Schedule::find($request->schedule_id);
        $course = Course::find($schedule->course->id);
        $price = $course->price;    // 価格
        $tax = $course->tax();      // 税金

        // 予約済みかどうかチェック
        $reservation_count = Reservation::where('user_id', '=', $user->id)->where('schedule_id', '=', $request->schedule_id)->get()->count();
        if ($reservation_count) 
        {
            return  redirect()->route('user.classroom_reservation.calendar', ['id' => $schedule->staff_id])->with('status', '予約済みです');
        }

        /* キャンセル待ち */
        if ($schedule->capacity == 0) 
        {
            // 予約済みかどうかチェック
            $wait_list_count = WaitListReservation::where('user_id', $user->id)->where('schedule_id', '=', $request->schedule_id)->get()->count();
            if ($wait_list_count) 
            {
                return  redirect()->route('user.classroom_reservation.calendar', ['id' => $schedule->staff_id])->with('status', '予約済みです');
            }

            // 予約待ちテーブルへ追加
            $wait_list = new WaitListReservation;
            $wait_list->user_id = $user->id;
            $wait_list->schedule_id = $request->schedule_id;
            if ($request->no_point==1) 
            {
                $wait_list->no_point = true;
            } 
            else 
            {
                $wait_list->no_point = false;
            }
            $wait_list->save();
            
            $wait_count = WaitListReservation::where('schedule_id', $request->schedule_id)->get()->count();

            $mail_classification = "cancel_machi";
            $mail_title = "【".$schedule->staff->room->name."】". $schedule->course->name ."(". date('Y年m月d日 H時i分', strtotime($schedule->start)) . ")のキャンセル待ち予約を受け付けました。";
            $mail_data = [
                'user_id'           => $user->id,
                'user_name'         => $user->name,
                'user_kana'         => $user->kana,
                'user_email'        => $user->email,
                'user_address'      => "〒" . $user->zip_code . " ". $user->pref . $user->address,
                'user_tel'          => $user->tel,
                'course_name'       => $schedule->course->name,
                'staff_name'        => $schedule->staff->name,
                'room_name'         => $schedule->staff->room->name,
                'room_address'      => $schedule->staff->room->address,
                'price'             => number_format($price)."円",
                'tax'               => number_format($tax)."円",
                'tax_price'         => number_format($price + $tax)."円",
                'start'             => date('Y年m月d日 H時i分', strtotime($schedule->start)),
                'cancel_rank'       => $wait_count
            ];
        } 
        else 
        {
            // 予約をする
            $reservation = new Reservation;
            $reservation->user_id = $user->id;
            $reservation->schedule_id = $request->schedule_id;

            if ($request->no_point==1) 
            {
                $reservation->is_contract = false;          // 仮契約
                $reservation->is_pointpay = false;
                $spent_point = 0;
            } 
            else 
            {
                if ($point > ($price + $tax)) 
                {
                    $reservation->is_contract = true;       // 本契約
                    $reservation->is_pointpay = true;
                    $spent_point = $price + $tax;           // 税込み価格

                    User::where('id', $user->id)->update(['point' => $point - $spent_point]);
                } 
                else 
                {
                    $reservation->is_contract = false;      // 仮契約
                    $reservation->is_pointpay = false;
                    $spent_point = 0;
                }
            }
            $reservation->spent_point = $spent_point;
            $reservation->save();

            /* 定員を減らす */
            Schedule::where('id', $schedule->id)->update(['capacity' => $schedule->capacity - 1]);
            $reservate_times = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
                ->join('staff', 'schedules.staff_id', '=', 'staff.id')
                ->where('reservations.user_id', '=', $user->id)
                ->where('schedules.staff_id', '=', $schedule->staff->id)
                ->where('schedules.is_zoom', '=', false)
                ->count();
            if (is_null($reservate_times)) 
            {
                $reservate_times = "初";
            }

            if ($reservation->is_contract) {
                $mail_classification = "hon_yoyaku";
                $mail_title = "【".$schedule->staff->room->name."】". $schedule->course->name ."(". date('Y年m月d日 H時i分', strtotime($schedule->start)) . ")の予約を受付ました。";
                $mail_data = [
                    'reservation_id'    => $reservation->id,
                    'course_name'       => $schedule->course->name,
                    'user_id'           => $user->id,
                    'user_name'         => $user->name,
                    'user_kana'         => $user->kana,
                    'user_email'        => $user->email,
                    'user_address'      => "〒" . $user->zip_code . " ". $user->pref . $user->address,
                    'user_tel'          => $user->tel,
                    'staff_name'        => $schedule->staff->name,
                    'room_name'         => $schedule->staff->room->name,
                    'room_address'      => $schedule->staff->room->address,
                    'price'             => number_format($price + $tax)."円",
                    'tax'               => number_format($tax)."円",
                    'tax_price'         => number_format($price + $tax)."円",
                    'times'             => $reservate_times."回",
                    'start'             => date('Y年m月d日 H時i分', strtotime($schedule->start))
                ];
            } else {
                $mail_classification = "kari_yoyaku";
                $mail_title = "【".$schedule->staff->room->name."】". $schedule->course->name ."(". date('Y年m月d日 H時i分', strtotime($schedule->start)) . ")の仮予約を受付ました。";
                $mail_data = [
                    'reservation_id'    => $reservation->id,
                    'course_name'       => $schedule->course->name,
                    'user_id'           => $user->id,
                    'user_name'         => $user->name,
                    'user_kana'         => $user->kana,
                    'user_email'        => $user->email,
                    'user_address'      => "〒" . $user->zip_code . " ". $user->pref . $user->address,
                    'user_tel'          => $user->tel,
                    'staff_name'        => $schedule->staff->name,
                    'room_name'         => $schedule->staff->room->name,
                    'room_address'      => $schedule->staff->room->address,
                    'price'             => number_format($price)."円",
                    'tax'               => number_format($tax)."円",
                    'tax_price'         => number_format($price + $tax)."円",
                    'times'             => $reservate_times."回",
                    'start'             => date('Y年m月d日 H時i分', strtotime($schedule->start))
                ];
            }
        }
                  
        /* 生徒にメールを送信 */
        Mail::to($user->email)->send(new ClassRoomReservationUserEmail($mail_classification, $mail_title, $mail_data));

        /* 先生と管理者()にメールを送信 */
        Mail::to($schedule->staff->email)->cc(Admin::find(1)->email)->send(new ClassRoomReservationStaffEmail($mail_classification, $mail_title, $mail_data));

        return  redirect()->route('user.classroom_reservation.calendar', ['id' => $schedule->staff_id])->with('status', '教室の予約を受付ました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
          
        // ここからはキャンセル処理
        $reservation = Reservation::find($id);
        $schedule = Schedule::find($reservation->schedule_id);

        /* 定員を増を元に戻す */
        $schedule->capacity = $schedule->capacity + 1;
        Schedule::where('id', $schedule->id)->update(['capacity' => $schedule->capacity]);

        /* ポイントを戻す */
        User::where('id', $user->id)->update(['point' => $user->point + $reservation->spent_point]);
        /* 予約を削除(訂正)する */
        Reservation::find($id)->delete();
        
        if ($reservation->is_contract) {
            $mail_title = "【予約キャンセル】".$schedule->staff->room->name."の予約のキャンセルを受付ました";
            $mail_data = [
                'action'            => "--- ". $schedule->staff->room->name."の予約のキャンセルを受付ました ---",
                'user_id'           => $user->id,
                'user_name'         => $user->name,
                'user_kana'         => $user->kana,
                'user_email'        => $user->email,
                'reservation_id'    => $reservation->id,
                'course_name'       => $schedule->course->name,
                'staff_name'        => $schedule->staff->name,
                'room_name'         => $schedule->staff->room->name,
                'room_address'      => $schedule->staff->room->address,
                'price'             => number_format($reservation->spent_point)."円(ポイントに還元済み)",
                'start'             => date('Y年m月d日 H時i分', strtotime($schedule->start))
            ];
        } else {
            $mail_title = "【仮予約キャンセル】".$schedule->staff->room->name."の仮予約のキャンセルを受付ました";
            $mail_data = [
                'action'            => "--- ". $schedule->staff->room->name."の仮予約のキャンセルを受付ました ---",
                'user_id'           => $user->id,
                'user_name'         => $user->name,
                'user_kana'         => $user->kana,
                'user_email'        => $user->email,
                'reservation_id'    => $reservation->id,
                'course_name'       => $schedule->course->name,
                'staff_name'        => $schedule->staff->name,
                'room_name'         => $schedule->staff->room->name,
                'room_address'      => $schedule->staff->room->address,
                'price'             => "--",
                'start'             => date('Y年m月d日 H時i分', strtotime($schedule->start))
            ];
        }

        /* 生徒にメールを送信 */
        Mail::to($user->email)->send(new ClassRoomCancelUserEmail($mail_title, $mail_data));
        /* 先生にメールを送信 */
        Mail::to($schedule->staff->email)->cc(Admin::find(1)->email)->send(new ClassRoomCancelStaffEmail($mail_title, $mail_data));

        // ここからはキャンセル待ち処理
        $wait_list_reservation = WaitListReservation::where('schedule_id', $reservation->schedule_id)->first();
        if (!is_null($wait_list_reservation)) {           // キャンセルあり
            // キャンセル待ち削除
            WaitListReservation::find($wait_list_reservation->id)->delete();

            // 予約をする
            // 生徒さんのポイント
            $point  = $user->point;
            //
            $price = Course::find($schedule->course->id)->price; /* ※バグ */

            $reservation = new Reservation;
            $reservation->user_id = $wait_list_reservation->user_id;
            $reservation->schedule_id = $schedule->id;
            if ($wait_list_reservation->no_point) {            // 前回の予約のとき仮払ボタンを押した
                $reservation->is_contract = false;          // 仮契約
                $reservation->is_pointpay = false;
                $spent_point = 0;
            } else {
                if ($point > ($price + $tax)) {
                    $reservation->is_contract = true;    // 本契約
                    $reservation->is_pointpay = true;
                    $spent_point = $price + $tax;           // 税込み価格

                    User::where('id', $user->id)->update(['point' => $point - $spent_point]);
                } else {
                    $reservation->is_contract = false;      // 仮契約
                    $reservation->is_pointpay = false;
                    $spent_point = 0;
                }
            }
            $reservation->spent_point = $spent_point;
            $reservation->save();

            /* 定員を減らす */
            Schedule::where('id', $schedule->id)->update(['capacity' => $schedule->capacity - 1]);
            $reservate_times = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
                ->join('staff', 'schedules.staff_id', '=', 'staff.id')
                ->where('reservations.user_id', '=', $wait_list_reservation->user_id)
                ->where('schedules.staff_id', '=', $schedule->staff->id)
                ->where('schedules.is_zoom', '=', false)
                ->count();
            if (is_null($reservate_times)) {
                $reservate_times = "初";
            }

            if ($reservation->is_contract) {
                $mail_classification = "hon_yoyaku";
                $mail_title = "【".$schedule->staff->room->name."】". $schedule->course->name ."(". date('Y年m月d日 H時i分', strtotime($schedule->start)) . ")の予約を受付ました。";
                $mail_data = [
                    'reservation_id'    => $reservation->id,
                    'course_name'       => $schedule->course->name,
                    'user_id'           => $wait_list_reservation->user->id,
                    'user_name'         => $wait_list_reservation->user->name,
                    'user_kana'         => $wait_list_reservation->user->kana,
                    'user_email'        => $wait_list_reservation->user->email,
                    'user_address'      => "〒" . $wait_list_reservation->user->zip_code . " ". $wait_list_reservation->user->pref . $wait_list_reservation->user->address,
                    'user_tel'          => $wait_list_reservation->user->tel,
                    'staff_name'        => $schedule->staff->name,
                    'room_name'         => $schedule->staff->room->name,
                    'room_address'      => $schedule->staff->room->address,
                    'price'             => number_format($price)."円",
                    'tax'               => number_format($tax)."円",
                    'tax_price'         => number_format($price + $tax)."円",
                    'times'             => $reservate_times."回",
                    'start'             => date('Y年m月d日 H時i分', strtotime($schedule->start))
                ];
            } else {
                $mail_classification = "kari_yoyaku";
                $mail_title = "【".$schedule->staff->room->name."】". $schedule->course->name ."(". date('Y年m月d日 H時i分', strtotime($schedule->start)) . ")の仮予約を受付ました。";
                $mail_data = [
                    'reservation_id'    => $reservation->id,
                    'course_name'       => $schedule->course->name,
                    'user_id'           => $wait_list_reservation->user->id,
                    'user_name'         => $wait_list_reservation->user->name,
                    'user_kana'         => $wait_list_reservation->user->kana,
                    'user_email'        => $wait_list_reservation->user->email,
                    'user_address'      => "〒" . $wait_list_reservation->user->zip_code . " ". $wait_list_reservation->user->pref . $wait_list_reservation->user->address,
                    'user_tel'          => $wait_list_reservation->user->tel,
                    'staff_name'        => $schedule->staff->name,
                    'room_name'         => $schedule->staff->room->name,
                    'room_address'      => $schedule->staff->room->address,
                    'price'             => number_format($price)."円",
                    'tax'               => number_format($tax)."円",
                    'tax_price'         => number_format($price + $tax)."円",
                    'times'             => $reservate_times."回",
                    'start'             => date('Y年m月d日 H時i分', strtotime($schedule->start))
                ];
            }

            
            /* 予約待ちの生徒にメールを送信 */
            Mail::to($wait_list_reservation->user->email)->send(new ClassRoomReservationUserEmail($mail_classification, $mail_title, $mail_data));
            /* 先生と管理者()にメールを送信 */
            Mail::to($schedule->staff->email)->cc(Admin::find(1)->email)->send(new ClassRoomReservationStaffEmail($mail_classification, $mail_title, $mail_data));

            $to_user_message = new AdminMessage;
            $to_user_message->direction = 'to_user';
            $to_user_message->admin_id =  1;
            $to_user_message->reservation_id = $reservation->id;
            $to_user_message->user_id = $wait_list_reservation->user->id;
            $to_user_message->staff_id = $schedule->staff->id;
            $to_user_message->message = 'キャンセル待ちから予約になりました';
            $to_user_message->expired_at = Carbon::now()->addDay(7);  // 期限は一週間
            $to_user_message->save();

            $to_staff_message = new AdminMessage;
            $to_staff_message->direction = 'to_staff';
            $to_staff_message->admin_id =  1;
            $to_staff_message->reservation_id = $reservation->id;
            $to_staff_message->user_id = $wait_list_reservation->user->id;
            $to_staff_message->staff_id = $schedule->staff->id;
            $to_staff_message->message = 'キャンセル待ちから予約になりました';
            $to_staff_message->expired_at = Carbon::now()->addDay(7);  // 期限は一週間
            $to_staff_message->save();
        }

        return  redirect()->route('user.classroom_reservation.calendar', ['id' => $schedule->staff_id])->with('status', '予約はキャンセルされました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel_destroy($id)
    {
        $user = Auth::user();
        $wait_list_reservation = WaitListReservation::find($id);
        $schedule = Schedule::find($wait_list_reservation->schedule_id);
        WaitListReservation::find($id)->delete();

        $mail_title = "【".$schedule->staff->room->name."】".$schedule->course->name."(". date('Y年m月d日 H時i分', strtotime($schedule->start)).")のキャンセル待ちのキャンセルを受付ました";
        $mail_data = [
                'action'            => "--- ". $schedule->staff->room->name."のキャンセル待ちのキャンセルを受付ました ---",
                'user_id'           => $user->id,
                'user_name'         => $user->name,
                'user_kana'         => $user->kana,
                'user_email'        => $user->email,
                'reservation_id'    => $wait_list_reservation->id,
                'course_name'       => $schedule->course->name,
                'staff_name'        => $schedule->staff->name,
                'room_name'         => $schedule->staff->room->name,
                'room_address'      => $schedule->staff->room->address,
                'price'             => "--",
                'tax'               => "--",
                'tax_price'         => "--",
                'start'             => date('Y年m月d日 H時i分', strtotime($schedule->start))
        ];

        /* 生徒にメールを送信 */
        Mail::to($user->email)->send(new ClassRoomCancelUserEmail($mail_title, $mail_data));

        /* 先生にメールを送信 */
        Mail::to($schedule->staff->email)->cc(Admin::find(1)->email)->send(new ClassRoomCancelStaffEmail($mail_title, $mail_data));

        return  redirect()->route('user.classroom_reservation.calendar', ['id' => $schedule->staff_id])->with('status', '予約はキャンセルされました');
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function calendar($id)
    {
        $user = Auth::user();

        /*先生情報を取り出す */
        $staff = Staff::find($id);
        $reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
                            ->join('staff', 'schedules.staff_id', '=', 'staff.id')
                            ->join('courses', 'schedules.course_id', '=', 'courses.id')
                            ->join('rooms', 'staff.id', '=', 'rooms.staff_id')
                            ->where('reservations.user_id', '=', $user->id)
                            ->where('schedules.is_zoom', '=', false)
                            ->where('schedules.start', '>', Carbon::now())
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

        $wait_list_reservations = WaitListReservation::join('schedules', 'wait_list_reservations.schedule_id', '=', 'schedules.id')
                            ->join('staff', 'schedules.staff_id', '=', 'staff.id')
                            ->join('courses', 'schedules.course_id', '=', 'courses.id')
                            ->join('rooms', 'staff.id', '=', 'rooms.staff_id')
                            ->where('wait_list_reservations.user_id', '=', $user->id)
                            ->where('schedules.is_zoom', '=', false)
                            ->where('schedules.start', '>', Carbon::now())
                            ->orderBy('schedules.start')
                            ->get([
                                'wait_list_reservations.id as id',
                                'wait_list_reservations.no_point as no_point',
                                'rooms.name as room_name',
                                'courses.name as course_name',
                                'staff.name as staff_name',
                                'courses.price as course_price',
                                'schedules.start as start'
                            ]);
   
        return view('user.classroom_reservation.calendar')->with(
            [
                'staff' => $staff,
                'reservations'=> $reservations,
                'wait_list_reservations' => $wait_list_reservations
            ]
        );
    }
}
