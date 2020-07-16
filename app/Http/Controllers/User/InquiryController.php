<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Reservation;
use Auth;
use Carbon\Carbon;

class InquiryController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getZoomSchedule(Request $request, $id)
    {
        $data = [];

        // 現在の日時
        $now = Carbon::now();
        $schedules = Schedule::where('staff_id',$id)
                                ->where('is_zoom', true)
                                ->whereBetween('start', array(str_replace('T', ' ', $request->start), str_replace('T', ' ', $request->end)))
                                ->get();
        foreach($schedules as $schedule) {
            $title = $schedule->course->name .":残".$schedule->capacity;
            $start = new Carbon($schedule->start);
            if ($start > $now)
            {
                $ev = [ 'id'=>$schedule->id, 
                    'title'     =>$title, 
                    'start'     =>str_replace(' ', 'T', $schedule->start), 
                    'end'       =>str_replace(' ', 'T', $schedule->end), 
                    'color'     =>'lightpink', 
                    'identifier'=>$schedule->identifier,
                    'url'       => '/user/zoom_reservation/create/'.$schedule->id,
                ];
            }
            else
            {
                $ev = [ 'id'=>$schedule->id, 
                    'title'     => $title, 
                    'start'     => str_replace(' ', 'T', $schedule->start), 
                    'end'       => str_replace(' ', 'T', $schedule->end), 
                    'color'     => 'lightpink', 
                    'identifier'=> $schedule->identifier
                ];         
            }
            array_push($data,$ev);
        }

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getClassrommSchedule(Request $request, $id)
    {
        $data = [];

        // 現在の日時
        $now = Carbon::now();
        $schedules = Schedule::where('staff_id',$id)
                        ->where('is_zoom', '0')
                        ->whereBetween('start', array(str_replace('T', ' ', $request->start), str_replace('T', ' ', $request->end)))
                        ->get();
        foreach($schedules as $schedule) {
            $start = new Carbon($schedule->start);
            if ($start > $now)
            {
                if ($schedule->capacity > 0) 
                {
                    $ev = [ 'id'=>$schedule->id, 
                        'title'     => $title = $schedule->course->name .":残".$schedule->capacity, 
                        'start'     => str_replace(' ', 'T', $schedule->start), 
                        'end'       => str_replace(' ', 'T', $schedule->end), 
                        'color'     => 'blue', 
                        'url'       => '/user/classroom_reservation/create/'.$schedule->id,
                        'extendedProps' => [
                            'schedule_id'       => $schedule->id,
                            'schedule_name'     => $schedule->name,
                            'schedule_capacity' => $schedule->capacity,
                        ]
                    ];
                }
                else 
                {
                    $ev = [ 'id'=>$schedule->id, 
                    'title'     => $title = $schedule->course->name .":残".$schedule->capacity, 
                    'start'     => str_replace(' ', 'T', $schedule->start), 
                    'end'       => str_replace(' ', 'T', $schedule->end), 
                    'color'     => 'blue', 
                    'extendedProps' => [
                        'schedule_id'       => $schedule->id,
                        'schedule_name'     => $schedule->name,
                        'schedule_capacity' => $schedule->capacity,
                    ]
                ];
                }
            }
            else
            {
                $ev = [ 'id'=>$schedule->id, 
                    'title'     => $title = $schedule->course->name."(済)", 
                    'start'     => str_replace(' ', 'T', $schedule->start), 
                    'end'       => str_replace(' ', 'T', $schedule->end), 
                    'color'     => 'lightblue',
                    'extendedProps' => [
                        'schedule_id'       => $schedule->id,
                        'schedule_name'     => $schedule->name,
                        'schedule_capacity' => $schedule->capacity,
                    ]
                ];         
            }
            array_push($data,$ev);
        }
        return response()->json($data);
    }
}
