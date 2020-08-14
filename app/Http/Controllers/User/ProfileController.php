<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserProfile;
use Auth;
use Carbon\Carbon;


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
        $birthday = new Carbon($user->birthday);
        return view('user.profile.edit')->with([
            'birthday_year'  => $birthday->year,
            'birthday_month' => $birthday->month,
            'birthday_day'   => $birthday->day,
            'user'  => $user 
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
            'zip_code' => $request->zip_code,
            'pref' => $request->pref,
            'address' => $request->address,
            'tel' => $request->tel,
            'birthday' => Carbon::create($request->year, $request->month, $request->day),
            'gender' => $request->gender,
        ];
        User::where('id', $id)->update($update);
        return back()->with('success', '編集完了しました');
    }


}
