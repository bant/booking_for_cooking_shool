<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Schedule;
use App\Models\Staff;
use App\Models\Room;
use App\Models\Course;
use App\Models\Book;
use App\Models\User;
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
        // zoom教室を持っている先生を列挙
        $staff = Staff::where('is_zoom',true)->get();
        return view('user.zoom_reservation.index')->with(["staff" => $staff]);
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
        ->where('reservations.user_id','=',$user->id)
        ->where('schedules.is_zoom','=',true)
        ->orderBy('schedules.start')
        ->get( [
                'reservations.id as id',
                'reservations.is_pointpay as is_pointpay',
               'rooms.name as room_name',
                'courses.name as course_name',
                'staff.name as staff_name',
                'courses.price as course_price',
                'schedules.start as start'
            ]);
   
        return view('user.zoom_reservation.calendar')->with(["staff" => $staff, 'reservations'=> $reservations]);
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
            return  redirect("/user/zoom_reservation/$schedule->staff_id/calendar")->with('status', '既に予約しています');
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

            return  redirect("/user/zoom_reservation/$schedule->staff_id/calendar")->with('status', '予約しました');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    
        return  redirect("/user/zoom_reservation/$schedule->staff_id/calendar")->with('status', '削除しました');
    }
}
