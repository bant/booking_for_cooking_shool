<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Log;

class InquiryController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $schedule = new Schedule;
        $schedule->staff_id = $request->staff_id;
        $schedule->title = $request->title;
        $schedule->description = ' ';
        $schedule->is_zoom  = $request->is_zoom;
        $schedule->start = $request->start;
        $schedule->end = $request->end;
      
        $schedule->save();

        echo json_encode(array('result'=>'success','color'=>'yellow'));
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
    public function update(Request $request)
    {
        $schedule = Schedule::find($request->id);
        $rservation_count = Reservation::where('schedule_id', $request->id)->get()->count();

        if ($rservation_count!=0) {
            return response()->json(['result'=>'failure3']);
        } else {
            $now = Carbon::now();
            $start = new Carbon($schedule->start);
            $req_start = new Carbon($request->start);

            if ($now > $req_start) {
                return response()->json(['result'=>'failure1']);
            } elseif ($now > $start) {
                return response()->json(['result'=>'failure2']);
            } else {
                $update = [
                    'start' => $request->start,
                    'end' => $request->end
                ];
    
                Schedule::where('id', $request->id)->update($update);
                return response()->json(['result'=>'success']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $rservation_count = Reservation::where('schedule_id', $request->id)->get()->count();
        // ゴミ箱に入ってる予約の個数
        $trash_rservation_count = Reservation::onlyTrashed()->where('schedule_id', $request->id)->get()->count();

        if ($rservation_count!=0) {
            return response()->json(['result'=>'failure']);
        } else {
            if ($trash_rservation_count!=0) {
                Reservation::onlyTrashed()->where('schedule_id', $request->id)->forceDelete();
            }

            Schedule::where('id', $request->id)->delete();
            return response()->json(['result'=>'success']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request, $id)
    {
        $data = [];
        $schedules = Schedule::where('staff_id', $id)
                                ->whereBetween('start', array(str_replace('T', ' ', $request->start), str_replace('T', ' ', $request->end)))
                                ->get();

        $now = Carbon::now();

        foreach ($schedules as $schedule) {
            $start = new Carbon($schedule->start);
            if ($start > $now) {
                $title = $schedule->course->name .":残".$schedule->capacity;
                if ($schedule->is_zoom == true) {
                    $ev = [
                        'id'        => $schedule->id,
                        'title'     => $title,
                        'start'     => str_replace(' ', 'T', $schedule->start),
                        'end'       => str_replace(' ', 'T', $schedule->end),
                        'color' => 'orange',
                        'extendedProps' => [
                            'schedule_id'   => $schedule->id,
                            'staff_id'      => $schedule->staff_id,
                        ]
                    ];
                } else {
                    $ev = [
                        'id'        => $schedule->id,
                        'title'     => $title,
                        'start'     => str_replace(' ', 'T', $schedule->start),
                        'end'       => str_replace(' ', 'T', $schedule->end),
                        'color'     => 'lightblue',
                        'staff_id'  => $schedule->staff_id,
                        'extendedProps' => [
                            'schedule_id'   => $schedule->id,
                            'staff_id'      => $schedule->staff_id,
                        ]
                    ];
                }
            } else {
                $title = $schedule->course->name .":残".$schedule->capacity;
                if ($schedule->is_zoom == true) {
                    $ev = [
                        'id'        => $schedule->id,
                        'title'     => $title,
                        'start'     => str_replace(' ', 'T', $schedule->start),
                        'end'       => str_replace(' ', 'T', $schedule->end),
                        'color' => 'lightgray',
                        'extendedProps' => [
                            'schedule_id'   => $schedule->id,
                            'staff_id'      => $schedule->staff_id,
                        ]
                    ];
                } else {
                    $ev = [
                        'id'        => $schedule->id,
                        'title'     => $title,
                        'start'     => str_replace(' ', 'T', $schedule->start),
                        'end'       => str_replace(' ', 'T', $schedule->end),
                        'color'     => 'BurlyWood',
                        'staff_id'  => $schedule->staff_id,
                        'extendedProps' => [
                            'schedule_id'   => $schedule->id,
                            'staff_id'      => $schedule->staff_id,
                        ]
                    ];
                }
            }

            array_push($data, $ev);
        }

        return response()->json($data);
    }
}
