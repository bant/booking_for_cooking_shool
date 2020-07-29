<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Schedule;
use App\Models\Staff;
use App\Models\Zoom;
use App\Models\Course;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ZoomReservationUserEmail;
use App\Mail\ZoomReservationStaffEmail;
use App\Mail\ZoomCancelUserEmail;
use App\Mail\ZoomCancelStaffEmail;
use Auth;

class ZoomReservationController extends Controller
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

        /*zoom情報を */
        $zoom = Zoom::all()->first();
        if (!is_null($zoom))
        {
            return  redirect()->route('user.zoom_reservation.calendar', ['id' => $zoom->staff_id]);
        }
        else 
        {
            return  view('user.room_reservation.index');
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
        return view('user.zoom_reservation.create')->with(["schedule" => $schedule]);
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

        $reservations = Reservation::where('user_id','=',$user->id)
            ->where('schedule_id','=',$request->schedule_id)->get();
        $schedule = Schedule::find($request->schedule_id);


        if ($reservations->count())
        {
            return  redirect(route('user.zoom_reservation.calendar', ['id' => $schedule->staff_id]))->with('status', '予約済みです');
        }
        else 
        {
            // 生徒さんのポイント
            $point  = $user->point;
            $price = Course::find($schedule->course->staff->id)->price;

            $reservation = new Reservation();
            $reservation->user_id = $user->id;
            $reservation->schedule_id = $request->schedule_id;
   
            if ($point > $price)
            {
                $reservation->is_pointpay = true;

                $update = [
                    'point' => $point - $price,
                ];
                User::where('id', $user->id)->update($update);

                $book_price = $price;
            }
            else
            {
                $reservation->is_pointpay = false;
                $book_price = 0;
            }
            $reservation->save();

            /* 帳簿につける */
            $book = new Book();
            $book->reservation_id = $reservation->id;
            $book->point = $book_price;
            $book->save();

            /* 定員を減らす */
            Schedule::where('id', $schedule->id)->update(['capacity' => $schedule->capacity - 1]);

            $reservate_times = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
            ->join('staff', 'schedules.staff_id', '=', 'staff.id')
            ->where('reservations.user_id','=',$user->id)
            ->where('schedules.staff_id','=',$schedule->staff->id)
            ->where('schedules.is_zoom','=',true)
            ->count();
            if (is_null($reservate_times))
            {
                $reservate_times = "初";
            } 

            if ($book_price == 0) 
            {
                $mail_title = "【仮予約受付】".$schedule->staff->zoom->name."のZOOM教室の仮予約を受付ました。";
                $mail_data = [
                    'action'            => "--- ". $schedule->staff->zoom->name."のZOOM教室の仮予約を受付ました。 ---",
                    'user_name'         => $user->name,
                    'user_email'        => $user->email,
                    'reservation_id'    => $reservation->id,
                    'course_name'       => $schedule->course->name,
                    'staff_name'        => $schedule->staff->name,
                    'price'             => number_format($price)."円",
                    'times'             => $reservate_times."回",
                    'start'             => date('Y年m月d日 H時i分', strtotime($schedule->start)),
                    'zoom_invitation'   => $schedule->zoom_invitation,
                ];
            }
            else
            {
                $mail_title = "【予約受付】".$schedule->staff->zoom->name."の予約を受付ました。";
                $mail_data = [
                    'action'            => "--- ". $schedule->staff->zoom->name."の予約を受付ました。 ---",
                    'user_name'         => $user->name,
                    'user_email'        => $user->email,
                    'reservation_id'    => $reservation->id,
                    'course_name'       => $schedule->course->name,
                    'staff_name'        => $schedule->staff->name,
                    'price'             => number_format($price)."円",
                    'times'             => $reservate_times."回",
                    'start'             => date('Y年m月d日 H時i分', strtotime($schedule->start)),
                    'zoom_invitation'   => $schedule->zoom_invitation,
                ];
            }

            /* 生徒にメールを送信 */
            Mail::to($user->email)->send(new ZoomReservationUserEmail($mail_title ,$mail_data));

            /* 先生にメールを送信 */
            Mail::to($schedule->staff->email)->send(new ZoomReservationStaffEmail($mail_title ,$mail_data));

            return  redirect(route('user.zoom_reservation.calendar', ['id' => $schedule->staff_id]))->with('status', 'ZOOM教室の予約しました');
        }
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
        $reservation = Reservation::find($id)->first();
        $schedule = Schedule::find($reservation->schedule_id)->first();
        $book = Book::where('reservation_id', $id)->first();
        

        /* 定員を増を元に戻す */
        Schedule::where('id', $schedule->id)->update(['capacity' => $schedule->capacity + 1]);
        /* ポイントを戻す */
        User::where('id', $user->id)->update(['point' => $user->point + $book->point]);
        /* 帳簿を削除(訂正)する */
        Book::where('reservation_id', $id)->delete();
        /* 予約を削除(訂正)する */
        Reservation::find($id)->delete();
      
        if ($book->point == 0) 
        {
            $mail_title = "【仮予約キャンセル】".$schedule->staff->zoom->name."の仮予約のキャンセルを受付ました。";
            $mail_data = [
                'action'            => "--- ". $schedule->staff->zoom->name."の仮予約のキャンセルを受付ました。 ---",
                'user_name'         => $user->name,
                'user_email'        => $user->email,
                'reservation_id'    => $reservation->id,
                'course_name'       => $schedule->course->name,
                'staff_name'        => $schedule->staff->name,
                'price'             => "--",
                'start'             => date('Y年m月d日 H時i分', strtotime($schedule->start))
            ];
        }
        else
        {
            $mail_title = "【予約キャンセル】".$schedule->staff->zoom->name."の予約をキャンセルを受付ました。";
            $mail_data = [
                'action'            => "--- ". $schedule->staff->zoom->name."の予約を受付ました。 ---",
                'user_name'         => $user->name,
                'user_email'         => $user->email,
                'reservation_id'    => $reservation->id,
                'course_name'       => $schedule->course->name,
                'staff_name'        => $schedule->staff->name,
                'price'             => number_format($book->point)."円(ポイントに還元済み)",
                'start'             => date('Y年m月d日 H時i分', strtotime($schedule->start))
            ];
        }

        /* 生徒にメールを送信 */
        Mail::to($user->email)->send(new ZoomCancelUserEmail($mail_title ,$mail_data));

        /* 先生にメールを送信 */
        Mail::to($schedule->staff->email)->send(new ZoomCancelStaffEmail($mail_title ,$mail_data));

        return  redirect(route('user.zoom_reservation.calendar', ['id' => $schedule->staff_id]))->with('status', 'ZOOM教室の予約をキャンセルしました');
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
        $zooms = Zoom::all();
        $reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
        ->join('staff', 'schedules.staff_id', '=', 'staff.id')
        ->join('courses', 'schedules.course_id', '=', 'courses.id')
        ->join('zooms', 'staff.id', '=', 'zooms.staff_id')
        ->where('reservations.user_id','=',$user->id)
        ->where('schedules.is_zoom','=',true)
        ->orderBy('schedules.start')
        ->get( [
                'reservations.id as id',
                'reservations.is_pointpay as is_pointpay',
                'zooms.name as zoom_name',
                'courses.name as course_name',
                'staff.name as staff_name',
                'courses.price as course_price',
                'schedules.start as start'
            ]);
   
        return view('user.zoom_reservation.calendar')->with(
            [
                'zooms' => $zooms,
                'staff' => $staff, 
                'reservations'=> $reservations
            ]);
    }
}
