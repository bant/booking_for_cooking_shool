<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Carbon\Carbon;

use App\Models\UserStaffMessage;
use App\Models\UserAdminMessage;

class MessageController extends Controller
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
     * 
     */
    public function sendMessage()
    {
        
    }
    /**
     * 
     */
    public function user_list()
    {
        $staff = Auth::user();
        $messages = UserStaffMessage::where('staff_id',$staff->id)
                                    ->where('dirction', 'to_staff')
                                    ->where('expired_at', '>' , Carbon::now())
                                    ->get();  

         return view('staff.message.user_list')->with(["messages"=> $messages]);
    }

    /**
     * 
     */
    public function user_search()
    {
        return view('staff.message.user_search');
    }

    /**
     * 
     */
    public function admin_list()
    {
        $staff = Auth::user();
        $messages = UserAdminMessage::where('staff_id',$staff->id)
                                    ->where('dirction', 'to_staff')
                                    ->where('expired_at', '>' , Carbon::now())
                                    ->get();  

        return view('staff.message.admin_index')->with([
                        "messages"        => $messages 
                    ]);
    }




}
