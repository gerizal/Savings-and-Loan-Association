<?php

namespace App\Http\Controllers;

use App\Models\BranchUnit;
use Illuminate\Http\Request;
use App\Models\ServiceUnit;
use Illuminate\Support\Facades\DB;


class BranchUnitController extends Controller
{
    public function __construct(){
        $this->middleware('role.feature.check:master_data_cabang,view', ['only' => ['index']]);
        $this->middleware('role.feature.check:master_data_cabang,create', ['only' => ['create', 'store']]);
        $this->middleware('role.feature.check:master_data_cabang,edit', ['only' => ['edit','update']]);
        $this->middleware('role.feature.check:master_data_cabang,delete', ['only' => ['delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master-data.branch-unit.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=[
            'data'   =>new BranchUnit,
            'form' =>[
                'url'       => route('master-data.branch-unit.store'),
                'method'    => 'POST',
                'files'     => true
            ],
            'service_unit'  => ServiceUnit::select('id','name')->get()->pluck('name','id')
        ];

        return view('master-data.branch-unit.form', $data);
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
            'number_code'=>'required',
            'unit_pelayanan_id'=>'required'
        ]);

        try {
            DB::beginTransaction();
            $data = new BranchUnit;
            $data->fill($request->only(['name', 'code_area', 'number_code', 'address']));
            $data->service_unit_id = $request->unit_pelayanan_id;
            $data->save();
            DB::commit();
            return redirect()->route('master-data.branch-unit.index')->withSuccess('Data Berhasil disimpan');
        } catch (\Exceptions $e) {
            \Log::info('Error',['data'=>$e]);
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
            'data'      => BranchUnit::find($id),
            'form' =>[
                'url'       => route('master-data.branch-unit.update', $id),
                'method'    => 'PUT',
                'files'     => true
            ],
            'service_unit'  => ServiceUnit::select('id','name')->get()->pluck('name','id')
        ];

        return view('master-data.branch-unit.form', $data);
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
            'number_code'=>'required',
            'unit_pelayanan_id'=>'required'
        ]);

        try {
            DB::beginTransaction();
            $data = BranchUnit::findOrFail($id);
            $data->fill($request->only(['name', 'code_area', 'number_code', 'address']));
            $data->service_unit_id = $request->unit_pelayanan_id;
            $data->save();
            DB::commit();
            return redirect()->route('master-data.branch-unit.index')->withSuccess('Data Berhasil diperbaharui');
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
            $data = BranchUnit::find($id);
            if($data){
                $data->delete();
                DB::commit();
                return redirect()->route('master-data.branch-unit.index')->withSuccess('Data Berhasil dihapus');
            }
            return redirect()->route('master-data.branch-unit.index')->withErrors('Data Tidak Ditemukan');
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
        $model = BranchUnit::with('serviceUnit')->get()->map(function($b){
            $b->unit_pelayanan = optional($b->serviceUnit)->name;
            return $b;
        });
        return datatables()->of($model)
        ->addColumn('action', function($row){
            $action = '<div class="text-center">
                    <a href="'.route('master-data.branch-unit.edit', $row->id).'" class="btn btn-warning btn-sm btn-md"><i class="fas fa-edit"></i> Edit</a>
                    <a href="'.route('master-data.branch-unit.destroy', $row->id).'" class="btn btn-danger  btn-sm btn-md btn-modal-delete"><i class="fas fa-trash"></i> Hapus</a>
                </div>';
            return $action;
        })
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }
}
