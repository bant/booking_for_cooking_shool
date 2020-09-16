<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Zoom;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreZoom;

class ZoomController extends Controller
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
        $staff = Auth::user();
        $zoom = Zoom::where('staff_id', $staff->id)->first();
        return view('staff.zoom.index', compact('zoom'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff.zoom.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreZoom $request)
    {
        $staff = Auth::user();
        $update = [
            'is_zoom' => true,
        ];
        Staff::where('id', $staff->id)->update($update);

        Zoom::create($request->all());
        return redirect()->route('staff.zoom.index')->with('success', '新規登録完了しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $zoom = Zoom::find($id);
        return view('staff.zoom.show', compact('zoom'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $zoom = Zoom::find($id);
        return view('staff.zoom.edit', compact('zoom'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreZoom $request, $id)
    {
        $staff = Auth::user();
        $update2 = [
            'is_zoom' => true,
        ];
        Staff::where('id', $staff->id)->update($update2);

        $update = [
            'name' => $request->name,
            'description' => $request->description
        ];
        Zoom::where('id', $id)->update($update);
        return back()->with('success', '編集完了しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staff = Auth::user();
        $update = [
            'is_zoom' => false,
        ];
        Staff::where('id', $staff->id)->update($update);
   
        Zoom::where('id', $id)->delete();
        return redirect()->route('staff.zoom.index')->with('success', 'オンライン教室を閉鎖しました。');
    }
}
