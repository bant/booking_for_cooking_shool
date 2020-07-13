<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Auth;

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
        $update = [
            'start' => $request->start,
            'end' => $request->end
        ];

        Schedule::where('id', $request->id)->update($update);
        return response()->json(['result'=>'success','color'=>'yellow']);
//        echo json_encode(array('result'=>'success','color'=>'yellow'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Schedule::where('id', $request->id)->delete();
        echo json_encode(array('result'=>'success'));
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
        $schedules = Schedule::where('staff_id',$id)
                                ->whereBetween('start', array(str_replace('T', ' ', $request->start), str_replace('T', ' ', $request->end)))
                                ->get();


        foreach($schedules as $schedule) {
            $title = $schedule->course->name .":残".$schedule->capacity;
            if ($schedule->is_zoom == true) 
            {
                $ev = [
                    'id'        => $schedule->id, 
                    'title'     => $title, 
                    'start'     => str_replace(' ', 'T', $schedule->start), 
                    'end'       => str_replace(' ', 'T', $schedule->end), 
                    'color'     => 'lightpink', 
                    'extendedProps' => [
                        'schedule_id'   => $schedule->id,
                        'staff_id'      => $schedule->staff_id, 
                        'identifier'    => $schedule->identifier
                    ]
                ];
            }
            else
            {
                $ev = [
                    'id'        => $schedule->id, 
                    'title'     => $title, 
                    'start'     => str_replace(' ', 'T', $schedule->start), 
                    'end'       => str_replace(' ', 'T', $schedule->end), 
                    'color'     => 'lightblue', 
                    'staff_id'  => $schedule->staff_id, 
                    'identifier'=> $schedule->identifier,
                    'extendedProps' => [
                        'staff_id'  => $schedule->staff_id, 
                        'identifier'=> $schedule->identifier
                    ] 
                ];
            }

            array_push($data, $ev);
        }

        return response()->json($data);
    }
}
