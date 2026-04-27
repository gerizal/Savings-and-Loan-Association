<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\InstallmentSchedule;
use App\Models\Bank;
use App\Models\Taspen;
use App\Models\Province;
use App\Models\Product;
use App\Models\FinanceType;
use App\Models\BranchUnit;
use App\Models\Referral;
use App\Models\ServiceUnit;
use App\Models\User;
use App\Models\District;
use App\Models\SubDistrict;
use App\Models\City;
use App\Models\Contract;
use Storage;

class InstallmentController extends Controller
{
    public function __construct(){
        $this->middleware('role.feature.check:angsuran,view', ['only' => ['index']]);
        $this->middleware('role.feature.check:angsuran,update', ['only' => ['paymentUpdate']]);
    }
    public function index(Request $request){
        $banks = Bank::select('id','name')->get();
        return view('installment.index', compact('banks'));
    }

    public function detail(Request $request, $application_id){
        $banks = Bank::select('id','name')->get();
        $application = Application::find($application_id);
        $contract = Contract::whereApplicationId($application->id)->first();
        $taspen = Taspen::find($application->taspen_id);
        $product = Product::find($application->product_id);
        $finance_type = FinanceType::find($application->product_id);
        $contract->akad_date = \Carbon\Carbon::parse($contract->created_at)->format('d-m-Y');
        $contract->settlement_date = \Carbon\Carbon::parse($contract->created_at)->addMonths($application->tenor)->format('d-m-Y');
        $application->url = route('installment.data-table',$application_id);
        return view('installment.detail', compact('banks','application','contract','taspen','product','finance_type'));
    }

    public function dataTableInstallment(Request $request){
        $data = InstallmentSchedule::installmentDataTabel($request);
        return datatables()->of($data)
            ->addColumn('action', function($row){
                $url=route('installment.payment.update', $row->id);
                $update = '<button class="btn btn-info btn-sm btn-md btn-payment" data-url="'.$url.'" data-status="0"  data-number="'.$row->number.'" data-akad="'.$row->akad.'"><i class="fas fa-check"> </i> Bayar</button>';
                if($row->status==1){
                    $update = '<button class="btn btn-danger btn-sm btn-md btn-cancel-payment" data-url="'.$url.'" data-status="1"  data-number="'.$row->number.'" data-akad="'.$row->akad.'"><i class="fas fa-times"></i> Batal Bayar</button>';
                }

                $action = '<div class="text-center">
                    '.$update.'
                    <a class="btn btn-info btn-sm btn-md" href="'.route("installment.detail",$row->application_id ).'"><i class="fas fa-eye"></i> Detail</a>
                </div>';
                return $action;
            })
            ->addColumn('status_label', function($row){
                $result = '<span class="payment-status text-success"><i><b>Lunas</b></i></span>';
                if($row->status==0){
                    $result = '<span class="payment-status text-warning"><i><b>Belum Bayar</b></i></span>';
                    $current = \Carbon\Carbon::now();
                    $due_date = \Carbon\Carbon::parse($row->payment_date);
                    if($current > $due_date){
                        $result = '<span class="payment-status text-danger"><i><b>Telat Bayar</b></i></span>';
                    }
                }
                return $result;
            })
            ->rawColumns(['action','status_label'])
            ->make(true);
    }

    public function dataTable(Request $request, $application_id){
        $data = InstallmentSchedule::dataTable($request, $application_id);
        return datatables()->of($data)
            ->addColumn('action', function($row){
                $url=route('installment.payment.update', $row->id);
                $action = '<button class="btn btn-success btn-sm btn-md btn-payment" data-url="'.$url.'" data-status="0" data-number="'.$row->number.'" data-akad="'.$row->akad.'"><i class="fas fa-check"></i> Bayar</button>';
                if($row->status==1){
                    $action = '<button class="btn btn-danger btn-sm btn-md btn-cancel-payment" data-url="'.$url.'" data-status="1"  data-number="'.$row->number.'" data-akad="'.$row->akad.'"><i class="fas fa-times"></i> Batal Bayar</button>';
                }
                return $action;
            })
            ->addColumn('status_label', function($row){
                $result = '<span class="payment-status text-success"><i><b>Lunas</b></i></span>';
                if($row->status==0){
                    $result = '<span class="payment-status text-warning"><i><b>Belum Bayar</b></i></span>';
                    $current = \Carbon\Carbon::now();
                    $due_date = \Carbon\Carbon::parse($row->payment_date);
                    if($current > $due_date){
                        $result = '<span class="payment-status text-danger"><i><b>Telat Bayar</b></i></span>';
                    }
                }
                return $result;
            })
            ->rawColumns(['action','status_label'])
            ->make(true);
    }

    public function paymentUpdate(Request $request, $id){

        $data = InstallmentSchedule::find($id);
        if($data){
            if($request->hasFile('file')){
                $file = $request->file;
                $original_name = $file->getClientOriginalName();
                $file_name = \Carbon\Carbon::now('UTC')->format('YmdHis') . '_' . $original_name;
                $file_path = "payments/$file_name";
                $localStorage = Storage::disk('azure');
                $localStorage->put($file_path, file_get_contents($file));
                $data->file = $file_path;
            }
            $data->status = boolval($request->status);
            $data->settlement_date = \Carbon\Carbon::now('UTC');
            $data->payment_type = $request->payment_type;
            $data->description = $request->description;
            $data->save();
        }

        $response=[
            'status'=>'success',
            'message'=>'success',
            'data'=>$data
        ];
        return response()->json($response, 200);
    }
}
