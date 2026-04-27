<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FinanceType;
use Illuminate\Support\Facades\DB;
class FinanceController extends Controller
{
    public function __construct(){
        $this->middleware('role.feature.check:master_data_pembiayaan,view', ['only' => ['index']]);
        $this->middleware('role.feature.check:master_data_pembiayaan,create', ['only' => ['create', 'store']]);
        $this->middleware('role.feature.check:master_data_pembiayaan,edit', ['only' => ['edit','update']]);
        $this->middleware('role.feature.check:master_data_pembiayaan,delete', ['only' => ['delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master-data.finance.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=[
            'data'   =>new FinanceType,
            'form' =>[
                'url'       => route('master-data.finance.store'),
                'method'    => 'POST',
                'files'     => true
            ]
        ];

        return view('master-data.finance.form', $data);
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
            'mutation_fee'=> 'required'
        ]);

        try {
            DB::beginTransaction();
            $data = new FinanceType;
            $data->fill($request->only($data->getFillable()));
            $data->save();
            DB::commit();
            return redirect()->route('master-data.finance.index')->withSuccess('Data Berhasil disimpan');
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
            'data'      => FinanceType::find($id),
            'form' =>[
                'url'       => route('master-data.finance.update', $id),
                'method'    => 'PUT',
                'files'     => true
            ]
        ];

        return view('master-data.finance.form', $data);
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
            'mutation_fee'=> 'required'
        ]);

        try {
            DB::beginTransaction();
            $data = FinanceType::findOrFail($id);
            $data->fill($request->only($data->getFillable()));
            $data->save();
            DB::commit();
            return redirect()->route('master-data.finance.index')->withSuccess('Data Berhasil diperbaharui');
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
            $data = FinanceType::find($id);
            if($data){
                $data->delete();
                DB::commit();
                return redirect()->route('master-data.finance.index')->withSuccess('Data Berhasil dihapus');
            }
            return redirect()->route('master-data.finance.index')->withErrors('error', 'Data Tidak Ditemukan');
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
        $model = FinanceType::all();

        return datatables()->of($model)
        ->addColumn('action', function($row){
            $action = '<div class="text-center">
                    <a href="'.route('master-data.finance.edit', $row->id).'" class="btn btn-warning btn-sm btn-md"><i class="fas fa-edit"></i> Edit</a>
                    <a href="'.route('master-data.finance.destroy', $row->id).'" class="btn btn-danger  btn-sm btn-md btn-modal-delete"><i class="fas fa-trash"></i> Hapus</a>
                </div>';
            return $action;
        })
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    /**
     * get dropdown data.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dropdown(Request $request)
    {
        $data = FinanceType::orderBy('Name','ASC');
        $data = $data->get();
        return response()->json($data);
    }
}
