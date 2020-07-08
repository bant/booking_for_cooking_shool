<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Course;
use Auth;

use App\Http\Requests\StoreSchedule;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staff = Auth::user();
        $schedules = Schedule::where('owner_id', $staff->id)->get();

        return view('staff.schedule.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $staff = Auth::user();
        $courses = Course::where('owner_id', $staff->id)->get(['id','name']);
        return view('staff.schedule.create', compact('courses'));
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
        $schedule->owner_id = $staff->id;
        $schedule->course_id = $request->course_id;
        $schedule->capacity = $request->capacity;
        $schedule->start = str_replace('T', ' ', $request->start);
        $schedule->end = str_replace('T', ' ', $request->end);
      
        $schedule->save();

//        return view('staff.home');
        return redirect()->route('staff.schedule.index')->with('message', 'Schedule created successfully.');
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
        return view('staff.schedule.show', compact('schedule'));
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
        $courses = Course::where('owner_id', $staff->id)->get(['id','name']);
        return view('staff.schedule.edit', compact('schedule','courses'));
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
            'owner_id'      => $staff->id,
            'course_id'     => $request->course_id,
            'capacity'      => $request->capacity,
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
        return redirect()->route('staff.schedule.index')->with('message', 'Schedule deleted successfully.');
    }
}
