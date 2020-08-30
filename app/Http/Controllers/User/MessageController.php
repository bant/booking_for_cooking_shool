<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaffMessage;
use App\Models\AdminMessage;
use Auth;

class MessageController extends Controller
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

    public function admin_delete($id)
    {
        AdminMessage::where('id',$id)->delete();
        return back()->with('success', 'メッセージを削除しました。');
    }

    public function staff_delete($id)
    {
        StaffMessage::where('id',$id)->delete();
        return back()->with('success', 'メッセージを削除しました。');
    }
}
