<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Course;
use App\Models\Zoom;
use Auth;

use Carbon\Carbon;

use App\Http\Requests\StoreSchedule;

class ClassRoomScheduleController extends Controller
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
        return redirect()->route('staff.schedule.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $staff = Auth::user();
        $courses = Course::where('staff_id', $staff->id)->get(['id','name']);
        $zoom_count = Zoom::where('staff_id','=','$staff->id')->count();
        return view('staff.classroom_schedule.create', compact('courses', 'zoom_count'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSchedule $request)
    {
        $staff = Auth::user();

        $schedule = new Schedule;
        $schedule->staff_id = $staff->id;
        $schedule->course_id = $request->course_id;
        $schedule->capacity = $request->capacity;
        $schedule->start = str_replace('T', ' ', $request->start);
        $dt = new Carbon($schedule->start);
        $schedule->end = $dt->addMinutes(150)->toDateTimeString();  // 二時間半
        $schedule->is_zoom = $request->is_zoom;
        $schedule->zoom_invitation = $request->zoom_invitation;

        $schedule->save();

        return redirect()->route('staff.schedule.index')->with('status', '教室スケジュールを登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $schedule = Schedule::find($id);
        return view('staff.classroom_schedule.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staff = Auth::user();
        $schedule = Schedule::find($id);
        $courses = Course::where('staff_id', $staff->id)->get(['id','name']);
        return view('staff.classroom_schedule.edit', compact('schedule','courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSchedule $request, $id)
    {
        $staff = Auth::user();
        $update = [
            'staff_id'      => $staff->id,
            'course_id'     => $request->course_id,
            'capacity'      => $request->capacity,
            'is_zoom'       => $request->is_zoom,
            'zoom_invitation'  => $request->zoom_invitation,
            'start'         => str_replace('T', ' ', $request->start),
            'end'           => str_replace('T', ' ', $request->end),
        ];

        Schedule::where('id', $id)->update($update);
        return back()->with('success', '編集完了しました');
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
        return redirect()->route('staff.classroom_schedule.index')->with('message', '教室スケジュールを削除しました');
    }
}
