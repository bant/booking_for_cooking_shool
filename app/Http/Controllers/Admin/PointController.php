<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\User;
use App\Models\Staff;
use App\Models\Schedule;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\PaymentDescription;

use App\Exports\Export;
use Carbon\Carbon;

use Auth;

class PointController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = null;
        /* ユーザ検索一覧ビュー表示 */
        return view('admin.point.index', compact('users'));
    }


    /**
     * 
     */
    public function user_search(Request $request)
    {
        // 指定アイテムを削除
        $request->session()->forget('status');
        $request->session()->forget('success');

        $users = null;

        if (!is_null($request->user_id)) 
        {
            $users = User::where('id', $request->user_id)->get();
        }
        else if (!is_null($request->name))
        {
            $users = User::where('name', 'like', "%$request->name%")->get();
        }
        else if (!is_null($request->address))
        {
            $users = User::where('address', 'like', "%$request->address%")->get();
        }

        if (!is_null($users))
        {
            if ($users->count() == 0)
            {
                $users = null;
            }
        }
        /* ユーザ検索一覧ビュー表示 */
        return view('admin.point.user_search')->with(["users" => $users]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user_edit(Request $request, $id)
    {
        // 指定アイテムを削除
        $request->session()->forget('status');
        $request->session()->forget('success');
        $user = User::where('id', $id)->first();
        $payments = Payment::where('user_id', $id)->get();
        $payment_descriptions = PaymentDescription::all();
        return view('admin.point.user_edit')
                    ->with(["user" => $user, 
                            "payments"  => $payments,
                            "payment_descriptions" => $payment_descriptions]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user_update(Request $request, $id)
    {
        // 指定アイテムを削除
        $request->session()->forget('status');
        $request->session()->forget('success');
        /* 訂正以外 */
        if($request->description_id != 2)
        {
            if ($request->point > 0)
            {
                $insert = [
                    'user_id'        => $id,
                    'point'          => $request->point,
                    'description_id' => $request->description_id,
                ];

                Payment::create($insert);

                $user = User::where('id', $id)->first();
                $update = [
                    'point' => $user->point + $request->point 
                ];

                User::where('id', $id)->update($update);
                $request->session()->put('status', 'ポイント追加しました');
            }
            else
            {
                $request->session()->put('status', '訂正時以外はマイナス入金できません');
            }
        }
        else    /* 訂正 */
        {
            if ($request->point < 0)
            {
                $user = User::where('id', $id)->first();

                if ($user->point < abs($request->point))
                {
                    $update = [
                        'point' => 0 
                    ];

                    $insert = [
                        'user_id'        => $id,
                        'point'          => -1 * $user->point,
                        'description_id' => $request->description_id,
                    ];
                }
                else
                {
                    $update = [
                        'point' =>  $user->point + $request->point
                    ];

                    $insert = [
                        'user_id'        => $id,
                        'point'          => $request->point,
                        'description_id' => $request->description_id,
                    ];
                }

                Payment::create($insert);
                User::where('id', $id)->update($update);
                $request->session()->put('status', 'ポイント修正しました');
            }
            else
            {
                $request->session()->put('status', '訂正時はマイナス入金してください');
            }
        }

        $user = User::where('id', $id)->first();
        $payment_descriptions = PaymentDescription::all();
        $payments = Payment::where('user_id',$id)->orderBy('created_at', 'asc')->take(20)->get();
        return view('admin.point.user_edit')
                    ->with(["user" => $user, 
                            'payments' => $payments,
                            "payment_descriptions" => $payment_descriptions]);   
    }

    /**
     * 
     */
    public function staff_select(Request $request)
    {
        $staff = Staff::all();  /* */
        /* ユーザ検索一覧ビュー表示 */
        return view('admin.point.staff_select')->with(['staff' => $staff]);
    }

    /**
     * 
     */
    public function staff_check($id)
    {
        $staff = Staff::find($id);

        // 現在の日時
        $now = Carbon::now();

        $previous_first_month_day = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $now_first_month_day = Carbon::now()->startOfMonth()->toDateString();
        $now_last_month_day = Carbon::now()->endOfMonth()->toDateString();
        $next_first_month_day = Carbon::now()->addMonth()->startOfMonth()->toDateString();
        $pointpay_class_reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
                                    ->join('staff', 'schedules.staff_id', '=', 'staff.id')
                                    ->join('users', 'reservations.user_id', '=', 'users.id')
                                    ->join('courses', 'schedules.course_id', '=', 'courses.id')
                                    ->join('rooms', 'staff.id', '=', 'rooms.staff_id')
                                    ->where('reservations.is_pointpay','=',true)
                                    ->where('schedules.staff_id','=',$staff->id)
                                    ->where('schedules.is_zoom','=',false)
                                    ->whereBetween('schedules.start', [$now_first_month_day, $now_last_month_day])
                                    ->orderBy('schedules.start')
                                    ->get([ 'reservations.id as id',
                                            'reservations.is_contract as is_contract',
                                            'reservations.is_pointpay as is_pointpay',
                                            'users.id as user_id',
                                            'users.name as user_name',
                                            'courses.name as course_name',
                                            'courses.price as course_price',
                                            'schedules.start as start'  ]);

        $no_pointpay_class_reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
                                            ->join('staff', 'schedules.staff_id', '=', 'staff.id')
                                            ->join('users', 'reservations.user_id', '=', 'users.id')
                                            ->join('courses', 'schedules.course_id', '=', 'courses.id')
                                            ->join('rooms', 'staff.id', '=', 'rooms.staff_id')
                                            ->where('reservations.is_pointpay','=',false)
                                            ->where('schedules.staff_id','=',$staff->id)
                                            ->where('schedules.is_zoom','=',false)
                                            ->whereBetween('schedules.start', [$now_first_month_day, $now_last_month_day])
                                            ->orderBy('schedules.start')
                                            ->get([ 'reservations.id as id',
                                                    'reservations.is_contract as is_contract',
                                                    'reservations.is_pointpay as is_pointpay',
                                                    'users.id as user_id',
                                                    'users.name as user_name',
                                                    'courses.name as course_name',
                                                    'courses.price as course_price',
                                                    'schedules.start as start'  ]);                                    



        $zoom_reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
                                    ->join('staff', 'schedules.staff_id', '=', 'staff.id')
                                    ->join('users', 'reservations.user_id', '=', 'users.id')
                                    ->join('courses', 'schedules.course_id', '=', 'courses.id')
                                    ->join('zooms', 'staff.id', '=', 'zooms.staff_id')
                                    ->where('reservations.is_pointpay','=',true)
                                    ->where('schedules.staff_id','=',$staff->id)
                                    ->where('schedules.is_zoom','=',true)
                                    ->whereBetween('schedules.start', [$now_first_month_day, $now_last_month_day])
                                    ->orderBy('schedules.start')
                                    ->get([ 'reservations.id as id',
                                            'reservations.is_contract as is_contract',
                                            'reservations.is_pointpay as is_pointpay',
                                            'zooms.name as zoom_name',
                                            'courses.name as course_name',
                                            'users.name as user_name',
                                            'users.id as user_id',
                                            'courses.price as course_price',
                                            'schedules.start as start' ]);



//        dd($class_reservations);

        /* ユーザ検索一覧ビュー表示 */
        return view('admin.point.staff_check')->with([
                'staff' => $staff, 
                'previous_first_month_day' => $previous_first_month_day,
                'now_first_month_day' => $now_first_month_day,
                'next_first_month_day' => $next_first_month_day,
                'pointpay_class_reservations'=>$pointpay_class_reservations,
                'no_pointpay_class_reservations'=>$no_pointpay_class_reservations,
                'zoom_reservations' => $zoom_reservations,
                ]);
    }

}
