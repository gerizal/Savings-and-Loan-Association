<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Response;
use Auth;
class AttendanceController extends Controller
{
    public function __construct(){
        $this->middleware('role.feature.check:absensi_karyawan,view', ['only' => ['index']]);
        $this->middleware('role.feature.check:laporan_absensi_karyawan,view', ['only' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $check_in_time = '';
        $check_out_time = '';
        $attendance = Attendance::where('user_id',Auth::id())->whereDate('created_at',date('Y-m-d'))->first();
        if($attendance)
        {
            $check_in_time = $attendance->check_in_time;
            $check_out_time = $attendance->check_out_time;
        }
        return view('attendance.index',compact('check_in_time','check_out_time'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attendance = Attendance::where('user_id',Auth::id())->whereDate('created_at',date('Y-m-d'))->first();
        if(!$attendance)
        {
            $attendance = new Attendance;
        }
        $attendance->user_id = Auth::id();
        $is_check_in = true;
        if($request->has('check_in_time'))
        {
            $attendance->check_in_time = date('Y-m-d ').$request->check_in_time;
        }
        if($request->has('check_out_time'))
        {
            $attendance->check_out_time = date('Y-m-d ').$request->check_out_time;
            $is_check_in = false;
        }
        $attendance->save();
        $result['is_check_in'] = $is_check_in;
        return Response::json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Request  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Request $attendance)
    {
        return view('attendance.report');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $attendance)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(attendance $attendance)
    {

    }

    public function datatable()
    {
        $model = Attendance::with('user:id,name')->get()->map(function($a){
            $a->name = optional($a->user)->name;
            return $a;
        });

        return datatables()->of($model)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }
}
