<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Application;
use App\Models\Dropping;
use App\Models\DroppingDetail;
use App\Models\SubmissionFile;
use App\Models\SubmissionGuarantee;
use App\Models\BranchUnit;
use App\Models\ServiceUnit;
use App\Models\Taspen;
use App\Models\Province;
use App\Models\Product;
use App\Models\FinanceType;
use App\Models\Referral;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\Approval;
use App\Models\Document;
use App\Models\Contract;
use App\Models\ApplicationFile;
use App\Models\Disbursement;
use Illuminate\Support\Facades\DB;
use Storage;

class ApplicationFilesController extends Controller
{
    public function applications(){
        $banks = Bank::select('id','name')->get();
        return view('files.application',compact('banks'));
    }

    public function applicationDataTable(Request $request)
    {
        $data = Application::filesDataTable($request);
        return datatables()->of($data)
        ->addColumn('application_file', function($row){
            $url=route('application.files.view', $row->application_id);
            $button = '<button type="button"  data-toggle="modal" data-target="#modalViewFile"  data-title="Berkas Pengajuan  '.$row->debitur.'" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'?type=application" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            return $button;
        })
        ->addColumn('contract_file', function($row){
            $url=generateSecureUrl($row->contract_file);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-type="pdf" data-title="Berkas Akad '.$row->debitur.'" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            if($row->contract_file==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        ->addColumn('settelment_file', function($row){
            $url=generateSecureUrl($row->settelment);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-type="pdf" data-title="Berkas Akad '.$row->debitur.'" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            if($row->settelment==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        ->addColumn('guarantee_file', function($row){
            $url=generateSecureUrl($row->guarantee);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-type="pdf" data-title="Berkas Akad '.$row->debitur.'" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            if($row->guarantee==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        ->addColumn('account_bank_file', function($row){
            $url=generateSecureUrl($row->account_bank);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-type="pdf" data-title="Berkas Akad '.$row->debitur.'" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            if($row->account_bank==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        ->addColumn('mutation_file', function($row){
            $url=generateSecureUrl($row->mutation);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-type="pdf" data-title="Berkas Akad '.$row->debitur.'" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            if($row->mutation==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        ->addColumn('flagging_file', function($row){
            $url=generateSecureUrl($row->flagging);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-type="pdf" data-title="Berkas Akad '.$row->debitur.'" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            if($row->flagging==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        ->addColumn('guarantee_status', function($row){
            $result='<span class="payment-status text-warning"><i><b>TBO</b></i></span>';
            if($row->status == 'approve'){
                $result='<span class="payment-status text-success"><i><b>Sukses</b></i></span>';
            }

            return $result;
        })
        ->addIndexColumn()
        ->rawColumns([
            'application_file',
            'contract_file',
            'settelment_file',
            'guarantee_file',
            'account_bank_file',
            'mutation_file',
            'flagging_file',
            'guarantee_status',
        ])
        ->make(true);
    }


    public function getSubmission(){
        $banks = Bank::select('id','name')->get();
        return view('files.submission-files',compact('banks'));
    }

    public function submissionDataTable(Request $request){
        $data = Application::submissionFilesDataTable($request);
        return datatables()->of($data)
        ->addColumn('checkbox', function($row){
            return '<div class="icheck-primary d-inline">
                        <input type="checkbox" class="si-check bank-check" id="bank_'.$row->id.'" data-id="'.$row->id.'" name="bank['.$row->id.']">
                        <label for="bank_'.$row->id.'"></label>
                    </div>';
        })
        ->addColumn('data', function($row){
            $data = Application::select(
                'applications.id as id',
                'applications.plafon as plafond',
                'applications.tenor',
                'taspens.nopen as nopen',
                'taspens.name as name',
                'products.name as product_name',
                'finance_types.name as finance_type',
                'applications.account_opening_fee',
                'applications.administration_fee as admin_bank',
                'contracts.number as contract_number',
                \DB::raw("CASE WHEN contracts.date IS NULL THEN '-' ELSE DATE_FORMAT(contracts.date,'%d-%m-%Y') END as contract_date"),
                'branch_units.name as branch_unit_name'
            )
            ->join('taspens','taspens.id','=','applications.taspen_id')
            ->join('products','products.id','=','applications.product_id')
            ->join('finance_types','finance_types.id','=','applications.finance_type_id')
            ->join('disbursements','disbursements.application_id','=','applications.id')
            ->leftjoin('contracts','contracts.application_id','=','applications.id')
            ->join('branch_units','branch_units.id','=','applications.branch_unit_id')
            ->whereIn('applications.id', explode(",",$row->application_ids))
            ->orderBy('applications.id','DESC')
            ->get();
            return $data;
        })
        ->addIndexColumn()
        ->rawColumns([
            'data',
            'checkbox'
        ])
        ->make(true);
    }

    public function printSubmission(Request $request){
        \Log::info('PRINT Submission');
        $validate = validator($request->all(), [
            'applications'=>'required|array',
            'date'=>'required',
            'number'=>'required'
        ]);

        $response = ['status'=>'error','message'=>'error'];

        if($validate->fails()){
            $response = ['message'=>$validate->errors(),'status'=>'error'];
        }else{
            try {
                \DB::beginTransaction();
                $user = \Auth::user();
                $applications = $request->applications;
                foreach($applications as $bank_id => $values){
                    $submission_file = new SubmissionFile;
                    $submission_file->number = $request->number;
                    $submission_file->date = date('Y-m-d',strtotime($request->date));
                    $submission_file->bank_id = $bank_id;
                    $submission_file->save();
                    $submission_file_id = $submission_file->id;
                    $bank = Bank::find($bank_id);
                    $branch = BranchUnit::find($user->branch_unit_id);
                    $total = 0;
                    $plafond=0;
                    $total_submission_file=0;
                    $applications = [];
                    $total_adm_fee = 0;
                    $total_block_installment = 0;
                    foreach($values as $application_id =>$value){
                        if($value=='on'){
                            $application = Application::find($application_id);
                            $application->submission_file_id=$submission_file->id;
                            $application->save();
                            $total++;
                            $plafond += $application->plafon;
                            $total_submission_file += $application->bank_installment;
                            $taspen = Taspen::find($application->taspen_id);
                            $type = FinanceType::find($application->finance_type_id);
                            $total_adm_fee +=$application->administration_fee;
                            $total_block_installment += $application->blockir_fee;
                            array_push($applications, [
                                'nopen'=>$taspen->nopen,
                                'debitur'=>$taspen->name,
                                'type'=>$type->name,
                                'plafond'=>formatIDR($application->plafond),
                                'adm_fee'=>formatIDR($application->administration_fee),
                                'service_fee'=>formatIDR(10000000),
                                'interest'=> '1 Bulan',
                                'block_installment'=>formatIDR($application->blockir_fee),
                                'submission_file'=>formatIDR($application->bank_installment),
                            ]);
                        }
                    }

                    $data = [
                        'number'=>$submission_file->number,
                        'debitur'=>$total,
                        'month'=>date('F', strtotime($submission_file->date)),
                        'year'=>date('Y', strtotime($submission_file->date)),
                        'receiver_name'=>$bank->name,
                        'plafond'=>formatIDR($plafond),
                        'submission_file'=>formatIDR($total_submission_file),
                        'account_number'=>env('APP_BANK_ACCOUNT_NUMBER'),
                        'account_name'=>env('APP_BANK_ACCOUNT_NAME'),
                        'bank_name'=>env('APP_BANK_NAME'),
                        'place_date'=>$branch->name.', '.date('d-m-Y', strtotime($submission_file->date)),
                        'operational_chief'=>env('APP_DIRECTUR'),
                        'finance_manager'=>env('APP_FINANCE_MANAGER'),
                        'total_plafond'=>formatIDR($plafond),
                        'total_adm_fee'=>formatIDR($total_adm_fee),
                        'total_service_fee'=>formatIDR(100000),
                        'total_interest'=>'',
                        'total_block_installment'=>formatIDR($total_block_installment),
                        'total_submission_file'=>formatIDR($total_submission_file),
                        'applications'=>$applications
                    ];

                    $pdf = Pdf::loadView('files.pdf.submission', ['data'=>$data])->setPaper('a4')->setOptions(['enable_remote' => true, 'chroot' => public_path('img')]);
                    $file_name = \Carbon\Carbon::now('UTC')->format('YmdHis') . '_' . str_replace(['/',' '],'_', $submission_file->number);
                    $file_path = "documents/submission/$submission_file_id/$file_name";
                    $localStorage = Storage::disk('azure');
                    $localStorage->put($file_path, $pdf->output());
                    $submission_file->file = $file_path;
                    $submission_file->plafond = $plafond;
                    $submission_file->debitur = $total;
                    $submission_file->status = 'queue';
                    $submission_file->save();
                    \Log::info('si url', ['data'=> generateSecureUrl($file_path)]);
                }
                \DB::commit();
                $response = ['status'=>'success','message'=>'success'];
            } catch (\Exception $e) {
                \DB::rollback();
                \Log::info('ERROR',['file'=>$e->getFile(),'line'=>$e->getLine(),'message'=>$e->getMessage()]);
            }

        }

        return response()->json($response, 200);
    }


    public function getSubmissionFiles(){
        $banks = Bank::select('id','name')->get();
        return view('files.upload-files',compact('banks'));
    }

    public function submissionFilesDataTable(Request $request){
        $data = SubmissionFile::dataTable($request);
        return datatables()->of($data)
        ->addColumn('print', function($row){
            $url=generateSecureUrl($row->file);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-type="pdf" data-title="Berkas Surat" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-print"></i></button>';
            if($row->file==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-print"></i></button>';
            }
            return $button;
        })
        ->addColumn('upload', function($row){
            $url=route('files.upload.submission-files');
            $button = '<button type="button"  class="btn btn-default btn-upload-file" data-id="'.$row->application_id.'" data-title="UPLOAD SURAT BERKAS"  data-url="'.$url.'"title="Upload"><i class="fas fa-upload"></i></button>';
            return $button;
        })
        ->addColumn('view', function($row){
            $url=generateSecureUrl($row->evidence);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-type="pdf" data-title="Berkas Surat" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            if($row->evidence==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        ->addColumn('status', function($row){
            $result='<span class="payment-status text-warning"><i><b>Antri</b></i></span>';
            if($row->status == 'on process'){
                $result='<span class="payment-status text-warning"><i><b>Proses</b></i></span>';
            }else if($row->status == 'reject'){
                $result='<span class="payment-status text-danger"><i><b>Ditolak</b></i></span>';
            }else if($row->status == 'pending'){
                $result='<span class="payment-status text-warning"><i><b>Pending</b></i></span>';
            }else if($row->status == 'approve'){
                $result='<span class="payment-status text-success"><i><b>Selesai</b></i></span>';
            }

            return $result;
        })
        ->addIndexColumn()
        ->rawColumns([
            'print',
            'upload',
            'view',
            'status'
        ])
        ->make(true);
    }

    public function uploadSubmissionFiles(Request $request){
        \Log::info('Upload Submission');
        $validate = validator($request->all(), [
            'file'=>'required|file',
            'id'=>'required',
        ]);

        $response = ['status'=>'error','message'=>'error'];

        if($validate->fails()){
            $response = ['message'=>$validate->errors(),'status'=>'error'];
        }else{
            try {
                \DB::beginTransaction();
                if($request->hasFile('file')){
                    $application_id = $request->id;
                    $submission_file = SubmissionFile::whereApplicationId($application_id)->first();
                    $submission_file->upload_date = \Carbon\Carbon::now('UTC');
                    $submission_file_id = $submission_file->id;
                    $file = $request->file;
                    $original_name = $file->getClientOriginalName();
                    $file_name = \Carbon\Carbon::now('UTC')->format('YmdHis') . '_' . $original_name;
                    $file_path = "documents/guarantee/$submission_file_id/$file_name";
                    $localStorage = Storage::disk('azure');
                    $localStorage->put($file_path, file_get_contents($file));
                    $submission_file->evidence = $file_path;
                    $submission_file->status = 'approve';
                    $submission_file->save();
                }

                \DB::commit();
                $response = ['status'=>'success','message'=>'success'];
            } catch (\Exception $e) {
                \DB::rollback();
                \Log::info('ERROR',['file'=>$e->getFile(),'line'=>$e->getLine(),'message'=>$e->getMessage()]);
            }

        }

        return response()->json($response, 200);
    }


    public function getGuarantee(){
        $banks = Bank::select('id','name')->get();
        return view('files.submission-guarantee',compact('banks'));
    }

    public function guaranteeDataTable(Request $request){
        $data = Application::submissionGuaranteeDataTable($request);
        return datatables()->of($data)
        ->addColumn('checkbox', function($row){
            return '<div class="icheck-primary d-inline">
                        <input type="checkbox" class="si-check bank-check" id="bank_'.$row->id.'" data-id="'.$row->id.'" name="bank['.$row->id.']">
                        <label for="bank_'.$row->id.'"></label>
                    </div>';
        })
        ->addColumn('data', function($row){
            $data = Application::select(
                'applications.id as id',
                'applications.plafon as plafond',
                'applications.tenor',
                'taspens.nopen as nopen',
                'taspens.name as name',
                'products.name as product_name',
                'finance_types.name as finance_type',
                'applications.account_opening_fee',
                'applications.administration_fee as admin_bank',
                'contracts.number as contract_number',
                \DB::raw("CASE WHEN contracts.date IS NULL THEN '-' ELSE DATE_FORMAT(contracts.date,'%d-%m-%Y') END as contract_date"),
                'branch_units.name as branch_unit_name'
            )
            ->join('taspens','taspens.id','=','applications.taspen_id')
            ->join('products','products.id','=','applications.product_id')
            ->join('finance_types','finance_types.id','=','applications.finance_type_id')
            ->join('contracts','contracts.application_id','=','applications.id')
            ->join('branch_units','branch_units.id','=','applications.branch_unit_id')
            ->whereIn('applications.id', explode(",",$row->application_ids))
            ->orderBy('applications.id','DESC')
            ->get();
            return $data;
        })
        ->addIndexColumn()
        ->rawColumns([
            'data',
            'checkbox'
        ])
        ->make(true);
    }

    public function printGuarantee(Request $request){
        $validate = validator($request->all(), [
            'applications'=>'required|array',
            'date'=>'required',
            'number'=>'required'
        ]);

        $response = ['status'=>'error','message'=>'error'];

        if($validate->fails()){
            $response = ['message'=>$validate->errors(),'status'=>'error'];
        }else{
            try {
                \DB::beginTransaction();
                $user = \Auth::user();
                $applications = $request->applications;
                foreach($applications as $bank_id => $values){
                    $submission_guarantee = new SubmissionGuarantee;
                    $submission_guarantee->number = $request->number;
                    $submission_guarantee->date = date('Y-m-d',strtotime($request->date));
                    $submission_guarantee->bank_id = $bank_id;
                    $submission_guarantee->save();
                    $submission_guarantee_id = $submission_guarantee->id;
                    $bank = Bank::find($bank_id);
                    $branch = BranchUnit::find($user->branch_unit_id);
                    $total = 0;
                    $plafond=0;
                    $total_submission_guarantee=0;
                    $applications = [];
                    $total_adm_fee = 0;
                    $total_block_installment = 0;
                    foreach($values as $application_id =>$value){
                        if($value=='on'){
                            $application = Application::find($application_id);
                            $application->submission_guarantee_id=$submission_guarantee->id;
                            $application->save();
                            $total++;
                            $plafond += $application->plafon;
                            $total_submission_guarantee += $application->bank_installment;
                            $taspen = Taspen::find($application->taspen_id);
                            $type = FinanceType::find($application->finance_type_id);
                            $total_adm_fee +=$application->administration_fee;
                            $total_block_installment += $application->blockir_fee;
                            array_push($applications, [
                                'nopen'=>$taspen->nopen,
                                'debitur'=>$taspen->name,
                                'type'=>$type->name,
                                'plafond'=>formatIDR($application->plafond),
                                'adm_fee'=>formatIDR($application->administration_fee),
                                'service_fee'=>formatIDR(10000000),
                                'interest'=> '1 Bulan',
                                'block_installment'=>formatIDR($application->blockir_fee),
                                'submission_file'=>formatIDR($application->bank_installment),
                            ]);
                        }
                    }

                    $data = [
                        'number'=>$submission_guarantee->number,
                        'debitur'=>$total,
                        'month'=>date('F', strtotime($submission_guarantee->date)),
                        'year'=>date('Y', strtotime($submission_guarantee->date)),
                        'receiver_name'=>$bank->name,
                        'plafond'=>formatIDR($plafond),
                        'submission_file'=>formatIDR($total_submission_guarantee),
                        'account_number'=>env('APP_BANK_ACCOUNT_NUMBER'),
                        'account_name'=>env('APP_BANK_ACCOUNT_NAME'),
                        'bank_name'=>env('APP_BANK_NAME'),
                        'place_date'=>$branch->name.', '.date('d-m-Y', strtotime($submission_guarantee->date)),
                        'operational_chief'=>env('APP_DIRECTUR'),
                        'finance_manager'=>env('APP_FINANCE_MANAGER'),
                        'total_plafond'=>formatIDR($plafond),
                        'total_adm_fee'=>formatIDR($total_adm_fee),
                        'total_service_fee'=>formatIDR(100000),
                        'total_interest'=>'',
                        'total_block_installment'=>formatIDR($total_block_installment),
                        'total_submission_file'=>formatIDR($total_submission_guarantee),
                        'applications'=>$applications
                    ];

                    $pdf = Pdf::loadView('files.pdf.guarantee', ['data'=>$data])->setPaper('a4')->setOptions(['enable_remote' => true, 'chroot' => public_path('img')]);
                    $file_name = \Carbon\Carbon::now('UTC')->format('YmdHis') . '_' . str_replace(['/',' '],'_', $submission_guarantee->number);
                    $file_path = "documents/guarantee/$submission_guarantee_id/$file_name";
                    $localStorage = Storage::disk('azure');
                    $localStorage->put($file_path, $pdf->output());
                    $submission_guarantee->file = $file_path;
                    $submission_guarantee->plafond = $plafond;
                    $submission_guarantee->debitur = $total;
                    $submission_guarantee->status = 'queue';
                    $submission_guarantee->save();
                    \Log::info('si url', ['data'=> generateSecureUrl($file_path)]);
                }
                \DB::commit();
                $response = ['status'=>'success','message'=>'success'];
            } catch (\Exception $e) {
                \DB::rollback();
                \Log::info('ERROR',['file'=>$e->getFile(),'line'=>$e->getLine(),'message'=>$e->getMessage()]);
            }

        }

        return response()->json($response, 200);
    }


    public function getGuaranteeFiles(){
        $banks = Bank::select('id','name')->get();
        return view('files.upload-guarantee',compact('banks'));
    }

    public function guaranteeFilesDataTable(Request $request){
        $data = SubmissionGuarantee::dataTable($request);
        return datatables()->of($data)
        ->addColumn('print', function($row){
            $url=generateSecureUrl($row->file);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-type="pdf" data-title="Berkas Jaminan" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-print"></i></button>';
            if($row->file==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-print"></i></button>';
            }
            return $button;
        })
        ->addColumn('upload', function($row){
            $url=route('files.upload.guarantee-files');
            $button = '<button type="button"  class="btn btn-default btn-upload-file" data-id="'.$row->application_id.'" data-title="Upload Berkas Jaminan"  data-url="'.$url.'"title="Upload"><i class="fas fa-upload"></i></button>';
            return $button;
        })
        ->addColumn('view', function($row){
            $url=generateSecureUrl($row->evidence);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-type="pdf" data-title="Berkas Penyerahan Jaminan" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            if($row->evidence==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        ->addColumn('status', function($row){
            $result='<span class="payment-status text-warning"><i><b>Antri</b></i></span>';
            if($row->status == 'on process'){
                $result='<span class="payment-status text-warning"><i><b>Proses</b></i></span>';
            }else if($row->status == 'reject'){
                $result='<span class="payment-status text-danger"><i><b>Ditolak</b></i></span>';
            }else if($row->status == 'pending'){
                $result='<span class="payment-status text-warning"><i><b>Pending</b></i></span>';
            }else if($row->status == 'approve'){
                $result='<span class="payment-status text-success"><i><b>Selesai</b></i></span>';
            }

            return $result;
        })
        ->addIndexColumn()
        ->rawColumns([
            'print',
            'upload',
            'view',
            'status'
        ])
        ->make(true);
    }

    public function uploadGuaranteeFiles(Request $request){
        \Log::info('ULOAD GUARANTEE');
        $validate = validator($request->all(), [
            'file'=>'required|file',
            'id'=>'required',
        ]);

        $response = ['status'=>'error','message'=>'error'];

        if($validate->fails()){
            $response = ['message'=>$validate->errors(),'status'=>'error'];
        }else{
            try {
                \DB::beginTransaction();
                if($request->hasFile('file')){
                    $application_id = $request->id;
                    $submission_file = SubmissionGuarantee::whereApplicationId($application_id)->first();
                    $submission_file->upload_date = \Carbon\Carbon::now('UTC');
                    $submission_file_id = $submission_file->id;
                    $file = $request->file;
                    $original_name = $file->getClientOriginalName();
                    $file_name = \Carbon\Carbon::now('UTC')->format('YmdHis') . '_' . $original_name;
                    $file_path = "documents/guarantee/$submission_file_id/$file_name";
                    $localStorage = Storage::disk('azure');
                    $localStorage->put($file_path, file_get_contents($file));
                    $submission_file->evidence = $file_path;
                    $submission_file->status = 'approve';
                    $submission_file->save();
                }

                \DB::commit();
                $response = ['status'=>'success','message'=>'success'];
            } catch (\Exception $e) {
                \DB::rollback();
                \Log::info('ERROR',['file'=>$e->getFile(),'line'=>$e->getLine(),'message'=>$e->getMessage()]);
            }

        }

        return response()->json($response, 200);
    }

}
