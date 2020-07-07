<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
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
//        $schedule = Schedule::where('owner_id', $staff->id)->first();
//        dd($schedule->staff->name);

        return view('staff.schedule.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff.schedule.create');
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
        $schedule->title = $request->title;
        $schedule->description = $request->description;
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
        $schedule = Schedule::find($id);
        return view('staff.schedule.edit', compact('schedule'));
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
            'title'         => $request->title,
            'description'   => $request->description,
            'start'         => str_replace('T', ' ', $request->start),
            'end'           => str_replace('T', ' ', $request->end),
        ];

        Schedule::where('id', $id)->update($update);
//        return back()->with('success', '編集完了しました');
        return view('staff.home');
//        return redirect()->route('staff.home')->with('message', 'Schedule deleted successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     //   $schedule->delete();

        Schedule::where('id', $id)->delete();
    //    return redirect()->route('book.index')->with('success', '削除完了しました');

        return redirect()->route('staff.schedule.index')->with('message', 'Schedule deleted successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function calender()
    {
        return view('staff.schedule.calender');
    }
}
