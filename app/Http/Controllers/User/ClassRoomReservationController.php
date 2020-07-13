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

        /*教室情報を */
        $rooms = Room::all();
        return view('user.classroom_reservation.index')->with(["rooms" => $rooms]);
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
        ->where('schedules.is_zoom','=',0)
        ->orderBy('schedules.start')
        ->get( [
               'rooms.name as room_name',
                'courses.name as course_name',
                'staff.name as staff_name',
                'courses.price as course_price',
                'schedules.start as start'
            ]);
   
        return view('user.classroom_reservation.calendar')->with(["staff" => $staff, 'reservations'=> $reservations]);
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

        $reservations = Reservation::where('user_id','=',$user->id)
            ->where('schedule_id','=',$request->schedule_id)->get();

        $schedule = Schedule::find($request->schedule_id);


        // 生徒さんのポイント
        $point  = $user->point;
        $price = Course::find($schedule->course->staff->id)->price;

        $reservation = new Reservation();
        $reservation->user_id = $user->id;
        $reservation->schedule_id = $request->schedule_id;
   
        if ($point > $price)
        {
            $reservation->is_pointpay = true;
        }
        else
        {
            $reservation->is_pointpay = false;
        }
        $reservation->save();

        /* ポイントの移動 */
        if ($point > $price)
        {
            $book = new Book();
            $book->reservation_id = $reservation->id;
            $book->point = $price;
            $book->save();

            $update = [
                'point' => $point - $price,
            ];
            User::where('id', $user->id)->update($update);
        }
        return  redirect("/user/ClassroomSchedule/calendar/$schedule->staff_id");
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
        //
    }
}
