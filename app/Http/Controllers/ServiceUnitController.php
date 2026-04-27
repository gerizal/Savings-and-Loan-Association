<?php

namespace App\Http\Controllers;

use App\Models\ServiceUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ServiceUnitController extends Controller
{

    public function __construct(){
        $this->middleware('role.feature.check:master_data_pelayanan,view', ['only' => ['index']]);
        $this->middleware('role.feature.check:master_data_pelayanan,create', ['only' => ['create', 'store']]);
        $this->middleware('role.feature.check:master_data_pelayanan,edit', ['only' => ['edit','update']]);
        $this->middleware('role.feature.check:master_data_pelayanan,delete', ['only' => ['delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master-data.service-unit.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=[
            'data'   =>new ServiceUnit,
            'form' =>[
                'url'       => route('master-data.service-unit.store'),
                'method'    => 'POST',
                'files'     => true
            ]
        ];

        return view('master-data.service-unit.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'code_area'=>'required',
            'number_code'=>'required'
        ]);

        try {
            DB::beginTransaction();
            $data = new ServiceUnit;
            $data->fill($request->only($data->getFillable()));
            $data->save();
            DB::commit();
            return redirect()->route('master-data.service-unit.index')->withSuccess('Data Berhasil disimpan');
        } catch (\Exceptions $e) {
            DB::rollback();
            return \redirect()->back()->withInput($request->all())->withErrors($e->all());
        }
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
        $data=[
            'data'      => ServiceUnit::find($id),
            'form' =>[
                'url'       => route('master-data.service-unit.update', $id),
                'method'    => 'PUT',
                'files'     => true
            ]
        ];

        return view('master-data.service-unit.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'code_area'=>'required',
            'number_code'=>'required'
        ]);

        try {
            DB::beginTransaction();
            $data = ServiceUnit::findOrFail($id);
            $data->fill($request->only($data->getFillable()));
            $data->save();
            DB::commit();
            return redirect()->route('master-data.service-unit.index')->withSuccess('Data Berhasil diperbaharui');
        } catch (\Exceptions $e) {
            DB::rollback();
            return \redirect()->back()->withInput($request->all())->withErrors($e->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $data = ServiceUnit::find($id);
            if($data){
                $data->delete();
                DB::commit();
                return redirect()->route('master-data.service-unit.index')->withSuccess('Data Berhasil dihapus');
            }
            return redirect()->route('master-data.service-unit.index')->withErrors('Data Tidak Ditemukan');
        } catch (\Exceptions $e) {
            DB::rollback();
            return \redirect()->back()->withErrors($e->all());
        }
    }

    /**
     * get datatable.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {
        $model = ServiceUnit::all();
        return datatables()->of($model)
        ->addColumn('action', function($row){
            $action = '<div class="text-center">
                    <a href="'.route('master-data.service-unit.edit', $row->id).'" class="btn btn-warning btn-sm btn-md"><i class="fas fa-edit"></i> Edit</a>
                    <a href="'.route('master-data.service-unit.destroy', $row->id).'" class="btn btn-danger  btn-sm btn-md btn-modal-delete"><i class="fas fa-trash"></i> Hapus</a>
                </div>';
            return $action;
        })
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }
}
