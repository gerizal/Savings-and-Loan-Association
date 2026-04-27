<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use Illuminate\Support\Facades\DB;

class BankController extends Controller
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
            'data'   =>new Bank,
            'form' =>[
                'url'       => route('master-data.bank.store'),
                'method'    => 'POST',
                'files'     => true
            ]
        ];

        return view('master-data.finance.form-bank', $data);
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
            'administration_fee'=>'required',
            'installment_fee'=>'required',
            'management_fee'=>'required',
            'stamp_fee'=>'required',
            'account_opening_fee'=>'required',
            'flagging_fee'=>'required',
            'epotpen_fee'=>'required',
            'provision_fee'=>'required',
            'interest'=>'required',
            'coop_fee'=>'required',
            'address'=>'required',
            'logo'=>'required',
        ]);

        try {
            DB::beginTransaction();
            $data = new Bank;
            $data->fill($request->only($data->getFillable()));
            if ($request->hasFile('logo')) {
                $data->logo = $request->file('logo')->store('banks', 'public');
            }
            $data->save();
            DB::commit();
            return redirect()->route('master-data.finance.index')->withSuccess('Data Berhasil disimpan');
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
        $bank = Bank::find($id);
        $bank->management_fee       = intval($bank->management_fee);
        $bank->stamp_fee            = intval($bank->stamp_fee);
        $bank->account_opening_fee  = intval($bank->account_opening_fee);
        $bank->flagging_fee         = intval($bank->flagging_fee);
        $bank->epotpen_fee          = intval($bank->epotpen_fee);
        $bank->round_off            = intval($bank->round_off);
        $data=[
            'data'      => $bank,
            'form' =>[
                'url'       => route('master-data.bank.update', $id),
                'method'    => 'PUT',
                'files'     => true
            ]
        ];

        return view('master-data.finance.form-bank', $data);
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
            'administration_fee'=>'required',
            'installment_fee'=>'required',
            'management_fee'=>'required',
            'stamp_fee'=>'required',
            'account_opening_fee'=>'required',
            'flagging_fee'=>'required',
            'epotpen_fee'=>'required',
            'provision_fee'=>'required',
            'interest'=>'required',
            'coop_fee'=>'required',
            'address'=>'required'
        ]);

        try {
            DB::beginTransaction();
            $data = Bank::findOrFail($id);
            $data->fill($request->only($data->getFillable()));
            if ($request->hasFile('logo')) {
                $data->logo = $request->file('logo')->store('banks', 'public');
            }
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
            $data = Bank::find($id);
            if($data){
                $data->delete();
                DB::commit();
                return redirect()->route('master-data.finance.index')->withSuccess('Data Berhasil dihapus');
            }
            return redirect()->route('master-data.finance.index')->withErrors('Data Tidak Ditemukan');
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
    public function datatable(Request $request)
    {
        $user = \Auth::user();
        $user_role = user_role();

        $model = Bank::query()->select('banks.*', DB::raw('CASE WHEN is_syariah=1 THEN "Ya" ELSE "Tidak" END AS is_syariah'));
        if($user_role && in_array($user_role->slug, ['approval', 'bank'])){
            $model->where('banks.id', $user->bank_id);
        }

        return datatables()->of($model)
        ->addColumn('action', function($row){
            $action = '<div class="text-center">
                    <a href="'.route('master-data.bank.edit', $row->id).'" class="btn btn-warning btn-sm btn-md"><i class="fas fa-edit"></i> Edit</a>
                    <a href="'.route('master-data.bank.destroy', $row->id).'" class="btn btn-danger  btn-sm btn-md btn-modal-delete"><i class="fas fa-trash"></i> Hapus</a>
                </div>';
            return $action;
        })
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }
}
