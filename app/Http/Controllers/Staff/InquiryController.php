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
        $schedule->owner_id = $request->owner_id;
        $schedule->title = $request->title;
        $schedule->description = ' ';
        $schedule->is_zoom  = false;
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
        echo json_encode(array('result'=>'success','color'=>'yellow'));
/*
        $schedule = Schedule::firstOrNew(['identifier'=>$request->identifier]);

        $schedule->title = $request->title;
        $schedule->owner_id = $request->owner_id;
        $schedule->identifier = $request->identifier;
        $schedule->description = ' ';
        $schedule->start = date('Y-m-d H:i',strtotime(strstr($request->start,'GMT',true)));
        $schedule->end = date('Y-m-d H:i',strtotime(strstr($request->end,'GMT',true)));

      
        DB::transaction(function() use ($schedule) {
            try {
                $schedule->save();
            } catch (\Exception $e) {
                // エラー処理
            }
        });
        
        echo json_encode(array('result'=>'success','color'=>'yellow'));
*/
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
    public function get(Request $request, $id)
    {
        $data = [];
        $schedules = Schedule::where('owner_id',$id)
                                ->whereBetween('start', array(str_replace('T', ' ', $request->start), str_replace('T', ' ', $request->end)))
                                ->get();

        foreach($schedules as $schedule) {
            $ev = ['id'=>$schedule->id, 'title'=>$schedule->title, 'start'=>str_replace(' ', 'T', $schedule->start), 'end'=>str_replace(' ', 'T', $schedule->end), 'color'=>'lightpink', 'owner_id'=>$schedule->owner_id, 'identifier'=>$schedule->identifier];
            array_push($data,$ev);
        }

        return response()->json($data);
    }
}
