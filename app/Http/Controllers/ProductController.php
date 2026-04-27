<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\Bank;
use App\Models\Application;
class ProductController extends Controller
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
            'data'   =>new Product,
            'form' =>[
                'url'       => route('master-data.product.store'),
                'method'    => 'POST',
                'files'     => true
            ],
            'bank'=>Bank::select('id','name')->get()->pluck('name','id')
        ];

        return view('master-data.finance.form-product', $data);
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
            'insurance_fee'=>'required',
            'interest'=>'required',
            'min_age'=>'required',
            'max_age'=>'required',
            'max_paid_age'=>'required',
            'max_tenor'=>'required',
            'max_plafon'=>'required',
            'bank_id'=>'required',
        ]);

        try {
            DB::beginTransaction();
            $data = new Product;
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
            'data'      => Product::find($id),
            'form' =>[
                'url'       => route('master-data.product.update', $id),
                'method'    => 'PUT',
                'files'     => true
            ],
            'bank'=>Bank::select('id','name')->get()->pluck('name','id')
        ];

        return view('master-data.finance.form-product', $data);
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
            'insurance_fee'=>'required',
            'interest'=>'required',
            'min_age'=>'required',
            'max_age'=>'required',
            'max_paid_age'=>'required',
            'max_tenor'=>'required',
            'max_plafon'=>'required',
            'bank_id'=>'required',
        ]);

        try {
            DB::beginTransaction();
            $data = Product::findOrFail($id);
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
            $data = Product::find($id);
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
        $user = \Auth::user();
        $user_role = user_role();

        $model = Product::with('bank')->when(
            $user_role && in_array($user_role->slug, ['approval', 'bank']),
            fn($q) => $q->where('bank_id', $user->bank_id)
        )->get()->map(function($p){
            $p->bank_name = optional($p->bank)->name;
            return $p;
        });

        return datatables()->of($model)
        ->addColumn('action', function($row){
            $action = '<div class="text-center">
                    <a href="'.route('master-data.product.edit', $row->id).'" class="btn btn-warning btn-sm btn-md"><i class="fas fa-edit"></i> Edit</a>
                    <a href="'.route('master-data.product.destroy', $row->id).'" class="btn btn-danger  btn-sm btn-md btn-modal-delete"><i class="fas fa-trash"></i> Hapus</a>
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
        \Log::info('=== Dropdown Product Debug ===');
        \Log::info('Request age: ' . $request->age);
        \Log::info('Request taspen_id: ' . $request->taspen_id);
        \Log::info('Request mode: ' . $request->mode);

        $data = Product::orderBy('id','ASC');
        
        // Filter by age
        if(isset($request->age)){
            $data = $data->where('min_age','<=', $request->age)->where('max_age','>=', $request->age);
            \Log::info('Filtering by age: min_age <= ' . $request->age . ' AND max_age >= ' . $request->age);
        }

        // Get products before filtering by active loan
        $productsBeforeFilter = $data->get();
        \Log::info('Products matching age criteria: ' . $productsBeforeFilter->count());
        \Log::info('Product IDs: ' . $productsBeforeFilter->pluck('id')->toJson());

        // Reset query for next filter
        $data = Product::orderBy('id','ASC');
        if(isset($request->age)){
            $data = $data->where('min_age','<=', $request->age)->where('max_age','>=', $request->age);
        }

        // Check for active loans
        $activeLoan = Application::whereTaspenId($request->taspen_id)->whereIsPaid(0);
        if(isset($request->mode) && isset($request->id)){
            if($request->mode == 'edit'){
                $activeLoan = $activeLoan->whereNotIn('id',[$request->id]);
            }
        }
        $activeLoan = $activeLoan->get()->pluck('product_id');
        \Log::info('Active loan product IDs for taspen_id ' . $request->taspen_id . ': ' . $activeLoan->toJson());

        if($activeLoan && $activeLoan->count() > 0){
            $bank_ids = Bank::whereHas('products', fn($q) => $q->whereIn('id', $activeLoan))->pluck('id');
            \Log::info('Bank IDs to exclude: ' . $bank_ids->toJson());
            if($bank_ids && $bank_ids->count() > 0){
                $data = $data->whereNotIn('bank_id', $bank_ids);
            }
        }

        $data = $data->get();
        \Log::info('Final products count after all filters: ' . $data->count());
        \Log::info('Final product IDs: ' . $data->pluck('id')->toJson());

        $data->load('bank');
        foreach ($data as $dt) {
            if ($dt->bank) {
                $dt->name = $dt->name . ' (' . $dt->bank->code . ')';
            }
        }

        return response()->json($data);
    }
}
