<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Course;
use App\Models\Zoom;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use App\Http\Requests\StoreSchedule;

class ScheduleController extends Controller
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
        $courses = Course::where('staff_id', $staff->id)->get(['id','name']);

        $room_count = Room::where('staff_id', $staff->id)->count();
        if (is_null($room_count))
        {
            $room_count = 0;
        }

        $zoom_count = Zoom::where('staff_id', $staff->id)->count();
        if (is_null($zoom_count))
        {
            $zoom_count = 0;
        }

        return view('staff.schedule.calendar')->with([
                        "courses" => $courses, 
                        "room_count" => $room_count, 
                        "zoom_count" => $zoom_count, 
                    ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Schedule::where('id', $id)->delete();
        return redirect()->route('staff.schedule.index')->with('message', 'スケジュールを削除しました');
    }

    public function calendar()
    {
        $staff = Auth::user();
        $courses = Course::where('staff_id', $staff->id)->get(['id','name']);

        $room_count = Room::where('staff_id', $staff->id)->count();
        if (is_null($room_count))
        {
            $room_count = 0;
        }

        $zoom_count = Zoom::where('staff_id', $staff->id)->count();
        if (is_null($zoom_count))
        {
            $zoom_count = 0;
        }

        return view('staff.schedule.calendar')->with([
            "courses" => $courses, 
            "room_count" => $room_count, 
            "zoom_count" => $zoom_count, 
        ]);
    }
}
