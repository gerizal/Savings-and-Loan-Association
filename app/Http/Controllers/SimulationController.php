<?php

namespace App\Http\Controllers;

use App\Models\Simulation;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\FinanceType;
use App\Models\Taspen;

use Illuminate\Support\Facades\DB;


class SimulationController extends Controller
{
    public function __construct(){
        $this->middleware('role.feature.check:simulasi_pinjaman,view', ['only' => ['index']]);
        $this->middleware('role.feature.check:simulasi_pinjaman,create', ['only' => ['create', 'store']]);
        $this->middleware('role.feature.check:simulasi_pinjaman,edit', ['only' => ['edit','update']]);
        $this->middleware('role.feature.check:simulasi_pinjaman,delete', ['only' => ['delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('simulation.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $simulation = new Simulation;
        $simulation->simulation_date = date('d-m-Y');
        $data=[
            'data'   =>$simulation,
            'form' =>[
                'url'       => route('simulation.store'),
                'method'    => 'POST',
                'files'     => true
            ],
            'products' => [],
            'nopen' => Taspen::select('nopen as option','nopen as value')->get()->pluck('option','value'),
            'types' => FinanceType::select('id','name')->get()->pluck('name','id'),
            'mode'=>'create'
        ];

        return view('simulation.form', $data);
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
            'product_id'=>'required',
            'finance_type_id'=>'required',
            'nopen'=>'required',
            'name'=>'required',
            'address'=>'required',
            'birth_date'=>'required',
            'salary'=>'required',
            'tenor'=>'required',
            'plafon'=>'required',
        ]);

        try {
            DB::beginTransaction();
            $data = new Simulation;
            $data->fill($request->only($data->getFillable()));
            $data->save();
            DB::commit();
            return redirect()->route('simulation.index')->withSuccess('Data Berhasil disimpan');
        } catch (\Exceptions $e) {
            DB::rollback();

            return redirect()->back()->withInput($request->all())->withErrors($e->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Simulation  $simulation
     * @return \Illuminate\Http\Response
     */
    public function show(Simulation $simulation)
    {
        $simulation->simulation_date = date('d-m-Y');
        $simulation->blockir_fee=(float)$simulation->blockir_fee;
        $simulation->block_installments = $simulation->blockir_fee * $simulation->angsuran;
        $date=date_create($simulation->birth_date);
        $simulation->birth_date = date_format($date,"d-m-Y");
        $isTaspenData = Taspen::whereNopen($simulation->nopen)->first();
        $nopen = Taspen::select('nopen as option','nopen as value')->get()->pluck('option','value')->toArray();
        if(!$isTaspenData){
            $nopen[$simulation->nopen] = $simulation->nopen;
        }
        $data=[
            'data'   =>$simulation,
            'form' =>[
                'url'       => route('simulation.store'),
                'method'    => 'POST',
                'files'     => true
            ],
            'nopen' => $nopen,
            'products' => Product::select('id','name')->get()->pluck('name','id'),
            'types' => FinanceType::select('id','name')->get()->pluck('name','id'),
            'mode'=>'show'
        ];

        return view('simulation.form', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Simulation  $simulation
     * @return \Illuminate\Http\Response
     */
    public function edit(Simulation $simulation)
    {
        $simulation->simulation_date = date('d-m-Y');
        $simulation->blockir_fee=(float)$simulation->blockir_fee;
        $simulation->block_installments = $simulation->blockir_fee * $simulation->angsuran;
        $date=date_create($simulation->birth_date);
        $simulation->birth_date = date_format($date,"d-m-Y");
        $isTaspenData = Taspen::whereNopen($simulation->nopen)->first();
        $nopen = Taspen::select('nopen as option','nopen as value')->get()->pluck('option','value')->toArray();
        if(!$isTaspenData){
            $nopen[$simulation->nopen] = $simulation->nopen;
        }
        $data=[
            'data'   =>$simulation,
            'form' =>[
                'url'       => route('simulation.store'),
                'method'    => 'POST',
                'files'     => true
            ],
            'nopen' => $nopen,
            'products' => Product::select('id','name')->get()->pluck('name','id'),
            'types' => FinanceType::select('id','name')->get()->pluck('name','id'),
            'mode'=>'edit'
        ];

        return view('simulation.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Simulation  $simulation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Simulation $simulation)
    {
        $request->validate([
            'product_id'=>'required',
            'finance_type_id'=>'required',
            'nopen'=>'required',
            'name'=>'required',
            'address'=>'required',
            'birth_date'=>'required',
            'salary'=>'required',
            'tenor'=>'required',
            'plafon'=>'required',
        ]);

        try {
            DB::beginTransaction();
            $simulation->fill($request->only($simulation->getFillable()));
            $simulation->save();
            DB::commit();
            return redirect()->route('simulation.index')->withSuccess('Data Berhasil diperbaharui');
        } catch (\Exceptions $e) {
            DB::rollback();
            return \redirect()->back()->withInput($request->all())->withErrors($e->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Simulation  $simulation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Simulation::find($id);
        $data->delete();
        return redirect()->route('simulation.index')->withSuccess('Data Berhasil dihapus');
    }

    /**
     * get datatable.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {
        $simulation = Simulation::orderBy('id','DESC')->get();
        return datatables()->of($simulation)
        ->addColumn('action', function($row){
            $action = '<div class="text-center">
                    <a href="'.route('simulation.show', $row->id).'" class="btn btn-info btn-sm btn-md"><i class="fas fa-eye"></i> Detail</a>
                    <a href="'.route('simulation.edit', $row->id).'" class="btn btn-warning btn-sm btn-md"><i class="fas fa-edit"></i> Edit</a>
                    <a href="'.route('simulation.destroy', $row->id).'" class="btn btn-danger  btn-sm btn-md btn-modal-delete"><i class="fas fa-trash"></i> Hapus</a>
                </div>';
            return $action;
        })
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }
}
