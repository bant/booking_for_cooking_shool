<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\PaymentDescription;

use App\Exports\Export;
use Carbon\Carbon;

class UserController extends Controller
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
     * 
     */
    public function search(Request $request)
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
        return view('admin.user.search')->with(["users" => $users]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        return view('admin.user.edit')->with(["user" => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        return  redirect()->route('admin.user.search')->with('status', '生徒を停止しました');
    }


    /**
     * .
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function info($id)
    {
        $user = User::where('id', $id)->first();
        return view('admin.user.info')->with(["user" => $user]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function point_edit(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        $payments = Payment::where('user_id', $id)->get();
        $payment_descriptions = PaymentDescription::all();
        return view('admin.user.point_edit')
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
    public function point_update(Request $request, $id)
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
    public function deleted_search(Request $request)
    {
        $users = User::onlyTrashed()->whereNotNull('id')->get();
     
        /* 停止ユーザ検索一覧ビュー表示 */
        return view('admin.user.deleted_search')->with(["users" => $users]);
    }


    public function restore($id)
    {
        User::withTrashed()->find($id)->restore();

        $users = User::onlyTrashed()->whereNotNull('id')->get();
        /* 停止ユーザ検索一覧ビュー表示 */
        return view('admin.user.deleted_search')->with(["users" => $users]);
    }

    /**
     * 
     */
    public function export_users()
    {
        $users =User::all();
        // 現在の日時
        $now = Carbon::now();

        $view = view('admin.user.export_users')->with(['users' => $users]);
        $export_name = date('Y-m-d', strtotime($now)) ."_生徒一覧.xlsx";
        return \Excel::download(new Export($view), $export_name);
    }

}
