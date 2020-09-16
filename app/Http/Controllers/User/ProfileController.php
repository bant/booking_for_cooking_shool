<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserProfile;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Room;
use App\Models\Zoom;

class ProfileController extends Controller
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
     * 
     */
    public function showForm()
    {
        $user = Auth::user();
    //    $rooms = Room::all();
    //    $zooms = Zoom::all();

        $birthday = new Carbon($user->birthday);
        return view('user.profile.edit')->with([
            'birthday_year'  => $birthday->year,
            'birthday_month' => $birthday->month,
            'birthday_day'   => $birthday->day,
            'user'           => $user,
    //        'rooms'         => $rooms,
    //        'zooms'         => $zooms
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserProfile $request, $id)
    {
        $update = [
            'name' => $request->name,
            'kana' => $request->kana,
            'zip_code' => $request->zip_code,
            'pref' => $request->pref,
            'address' => $request->address,
            'tel' => $request->tel,
            'birthday' => Carbon::create($request->year, $request->month, $request->day),
            'gender' => $request->gender,
        ];
        User::where('id', $id)->update($update);
        return back()->with('success', 'プロフィールを更新しました');
    }
}
