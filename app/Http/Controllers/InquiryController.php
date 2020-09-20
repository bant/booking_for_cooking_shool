<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Schedule;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
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
        //        $this->middleware('auth:user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getClassroomSchedule(Request $request, $id)
    {
        $data = [];

        // 現在の日時
        $now = Carbon::now();
        $schedules = Schedule::where('staff_id', $id)
            ->where('is_zoom', false)
            ->whereBetween('start', array(str_replace('T', ' ', $request->start), str_replace('T', ' ', $request->end)))
            ->get();
        foreach ($schedules as $schedule) {
            $start = new Carbon($schedule->start);
            if ($start > $now) {
                if ($schedule->capacity > 0) {
                    $ev = [
                        'id' => $schedule->id,
                        'title'     => $schedule->course->name,
                        'start'     => str_replace(' ', 'T', $schedule->start),
                        'end'       => str_replace(' ', 'T', $schedule->end),
                        'color'     => 'blue',
                        'url'       =>  route('user.classroom_reservation.create', $schedule->id),
                        'extendedProps' => [
                            'start_end'         => date('H:i', strtotime($schedule->start)) . "〜" . date('H:i', strtotime($schedule->end)),
                            'schedule_id'       => $schedule->id,
                            'schedule_name'     => $schedule->course->name,
                            'schedule_capacity' => $schedule->capacity,
                            'staff_name'        => $schedule->staff->name,
                            'place'             => $schedule->staff->room->name,
                            'status'            => '開始前'
                        ]
                    ];
                } else {
                    $ev = [
                        'id'    => $schedule->id,
                        'title' => $schedule->course->name,
                        'start' => str_replace(' ', 'T', $schedule->start),
                        'end'   => str_replace(' ', 'T', $schedule->end),
                        'color' => 'blue',
                        'extendedProps' => [
                            'start_end'         => date('H:i', strtotime($schedule->start)) . "〜" . date('H:i', strtotime($schedule->end)),
                            'schedule_id'       => $schedule->id,
                            'schedule_name'     => $schedule->course->name,
                            'schedule_capacity' => $schedule->capacity,
                            'staff_name'        => $schedule->staff->name,
                            'place'             => $schedule->staff->room->name,
                            'status'            => '開始前'
                        ]
                    ];
                }
            } else {
                $ev = [
                    'id'        => $schedule->id,
                    'title'     => $schedule->course->name . "(済)",
                    'start'     => str_replace(' ', 'T', $schedule->start),
                    'end'       => str_replace(' ', 'T', $schedule->end),
                    'color'     => 'lightblue',
                    'extendedProps' => [
                        'start_end'         => date('H:i', strtotime($schedule->start)) . "〜" . date('H:i', strtotime($schedule->end)),
                        'schedule_id'       => $schedule->id,
                        'schedule_name'     => $schedule->course->name,
                        'schedule_capacity' => $schedule->capacity,
                        'staff_name'        => $schedule->staff->name,
                        'place'             => $schedule->staff->room->name,
                        'status'            => '終了'
                    ]
                ];
            }
            array_push($data, $ev);
        }
        return response()->json($data);
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
        $schedules = Schedule::where('staff_id', $id)
            ->where('is_zoom', true)
            ->whereBetween('start', array(str_replace('T', ' ', $request->start), str_replace('T', ' ', $request->end)))
            ->get();
        foreach ($schedules as $schedule) {
            $start = new Carbon($schedule->start);
            if ($start > $now) {
                if ($schedule->capacity > 0) {
                    $ev = [
                        'id'        => $schedule->id,
                        'title'     => $schedule->course->name,
                        'start'     => str_replace(' ', 'T', $schedule->start),
                        'end'       => str_replace(' ', 'T', $schedule->end),
                        'color' => 'maroon',
                        'url'       =>  route('user.classroom_reservation.create', $schedule->id),
                        'extendedProps' => [
                            'start_end'         => date('H:i', strtotime($schedule->start)) . "〜" . date('H:i', strtotime($schedule->end)),
                            'schedule_id'       => $schedule->id,
                            'schedule_name'     => $schedule->course->name,
                            'schedule_capacity' => $schedule->capacity,
                            'staff_name'        => $schedule->staff->name,
                            'place'             => $schedule->staff->zoom->name,
                            'status'            => '開始前'
                        ]
                    ];
                } else {
                    $ev = [
                        'id'        => $schedule->id,
                        'title'     => $schedule->course->name,
                        'start'     => str_replace(' ', 'T', $schedule->start),
                        'end'       => str_replace(' ', 'T', $schedule->end),
                        'color' => 'maroon',
                        'extendedProps' => [
                            'start_end'         => date('H:i', strtotime($schedule->start)) . "〜" . date('H:i', strtotime($schedule->end)),
                            'schedule_id'       => $schedule->id,
                            'schedule_name'     => $schedule->course->name,
                            'schedule_capacity' => $schedule->capacity,
                            'staff_name'        => $schedule->staff->name,
                            'place'             => $schedule->staff->zoom->name,
                            'status'            => '開始前'
                        ]
                    ];
                }
            } else {
                $ev = [
                    'id'        => $schedule->id,
                    'title'     => $schedule->course->name . "(済)",
                    'start'     => str_replace(' ', 'T', $schedule->start),
                    'end'       => str_replace(' ', 'T', $schedule->end),
                    'color' => 'orange',
                    'extendedProps' => [
                        'start_end'         => date('H:i', strtotime($schedule->start)) . "〜" . date('H:i', strtotime($schedule->end)),
                        'schedule_id'       => $schedule->id,
                        'schedule_name'     => $schedule->course->name,
                        'schedule_capacity' => $schedule->capacity,
                        'staff_name'        => $schedule->staff->name,
                        'place'             => $schedule->staff->zoom->name,
                        'status'            => '終了'
                    ]
                ];
            }
            array_push($data, $ev);
        }
        return response()->json($data);
    }

    /**
     * 
     * 
     * 
     */
    public function getClassroomScheduleAtMonth()
    {
        $base_array = [];

        // 現在の日時
        $now = Carbon::now();
        $now_first_month_day = Carbon::createFromTimestamp(strtotime($now))
            ->timezone(\Config::get('app.timezone'))->startOfMonth()->toDateString();
        $now_last_month_day = Carbon::createFromTimestamp(strtotime($now))
            ->timezone(\Config::get('app.timezone'))->endOfMonth()->toDateString();

        $real_schedules = Schedule::join('courses', 'schedules.course_id', '=', 'courses.id')
            ->join('course_categories', 'courses.category_id', '=', 'course_categories.id')
            ->where('course_categories.serach_index', 'like', "%real")
            ->whereBetween('schedules.start', [$now_first_month_day, $now_last_month_day])
            ->orderBy('course_categories.id')
            ->orderBy('schedules.staff_id')
            ->orderBy('schedules.start')
            ->get([
                'schedules.id as schedules_id',
                'schedules.staff_id as staff_id',
                'schedules.capacity as capacity',
                'schedules.start as start',
                'schedules.end as end',
                'course_categories.serach_index as search_index',
            ]);

        foreach ($real_schedules as $real_schedule) {
            $category = explode("-", $real_schedule->search_index);

            if ($category[1] != "real") {
                $base_array[$category[0]]['style'] = $category[1];
            }
            $base_array[$category[0]]['class_info']['staff_id'] = $real_schedule->staff_id;
            $base_array[$category[0]]['class_info']['capacity'] = $real_schedule->capacity;
            $base_array[$category[0]]['class_info']['start'] = str_replace(' ', 'T', $real_schedule->start);
            $base_array[$category[0]]['class_info']['end'] = str_replace(' ', 'T', $real_schedule->end);
        }

        return response()->json($base_array);
    }
}
