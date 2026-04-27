<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Taspen;
use App\Models\Province;
use App\Models\Product;
use App\Models\FinanceType;
use App\Models\Application;
use App\Models\BranchUnit;
use App\Models\Referral;
use App\Models\ServiceUnit;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Bank;
use App\Models\Approval;
use App\Models\Document;
use App\Models\Contract;
use App\Models\ApplicationFile;
use App\Models\Disbursement;
use App\Models\Dropping;
use App\Models\DroppingDetail;
use Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class InternalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::select('id','name')->get();

        return view('application.internal.index',compact('banks'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function document()
    {
        $banks = Bank::select('id','name')->get();
        return view('application.internal.document',compact('banks'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function disbursement()
    {
        $banks = Bank::select('id','name')->get();
        return view('application.internal.disbursement',compact('banks'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function secondDisbursement()
    {
        $banks = Bank::select('id','name')->get();
        return view('application.internal.second-disbursement',compact('banks'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function SIDisbursement()
    {
        $banks = Bank::select('id','name')->get();
        return view('application.internal.si-disbursement',compact('banks'));
    }


    public function printSIDisbursement(Request $request){
        $validate = validator($request->all(), [
            'bank'=>'required|array',
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
                $req_applications = $request->applications;
                foreach($request->bank as $bank_id => $checked_bank){
                    if($checked_bank=='on'){
                        $dropping = new Dropping;
                        $dropping->number = $request->number;
                        $dropping->date = date('Y-m-d',strtotime($request->date));
                        $dropping->bank_id = $bank_id;
                        $dropping->save();
                        $dropping_id = $dropping->id;
                        $bank = Bank::find($bank_id);
                        $branch = BranchUnit::find($user->branch_unit_id);
                        $branch_name = 'Bandung';
                        if($branch){
                            $branch_name = $branch->name;
                        }
                        $total = 0;
                        $plafond=0;
                        $total_dropping=0;
                        $bank_applications = [];
                        $total_adm_fee = 0;
                        $total_block_installment = 0;
                        $total_provision = 0;
                        $total_service_fee = 0;
                        $total_account_opening_fee = 0;

                        if(isset($req_applications[$bank_id])){
                            $applications = $req_applications[$bank_id];
                            foreach($applications as $application_id => $checked_application){
                                if($checked_application=='on'){
                                    $application = Application::find($application_id);
                                    $dropping_detail = new DroppingDetail;
                                    $dropping_detail->dropping_id=$dropping->id;
                                    $dropping_detail->application_id = $application_id;
                                    $dropping_detail->save();
                                    $application->status=2;
                                    $application->disbursement_status = 'queue';
                                    $application->dropping_id = $dropping->id;
                                    $application->save();
                                    $disbursement = Disbursement::whereApplicationId($application_id)->first();
                                    $disbursement->dropping_id=$dropping->id;
                                    $disbursement->status = 'queue';
                                    $disbursement->save();
                                    $total++;
                                    $plafond += $application->plafon;
                                    $cal_dropping = 0;
                                    if($bank->code=='BPR SIP'){
                                        $cal_dropping = $application->plafon - ($application->administration_fee + $application->blockir_fee + $application->provision_fee);
                                    }else{
                                        $cal_dropping = $application->plafon - ($application->administration_fee + $application->account_opening_fee + $application->provision_fee);
                                    }
                                    $total_dropping += $cal_dropping;
                                    $taspen = Taspen::find($application->taspen_id);
                                    $type = FinanceType::find($application->finance_type_id);
                                    $total_adm_fee +=$application->administration_fee;
                                    $total_block_installment += $application->blockir_fee;
                                    $total_provision += $application->provision_fee;
                                    $total_service_fee += $application->provision_fee;
                                    $total_account_opening_fee += $application->account_opening_fee;
                                    array_push($bank_applications, [
                                        'nopen'=>$taspen->nopen,
                                        'debitur'=>$taspen->name,
                                        'type'=>$type->name,
                                        'plafond'=>formatIDR($application->plafon),
                                        'adm_fee'=>formatIDR($application->administration_fee),
                                        'service_fee'=>formatIDR($application->provision_fee),
                                        'provision_fee'=>formatIDR($application->provision_fee),
                                        'interest'=> '1 Bulan',
                                        'block_installment'=>formatIDR($application->blockir_fee),
                                        'dropping'=>formatIDR( $cal_dropping),
                                        'account_opening_fee'=> formatIDR($application->account_opening_fee),
                                        'code_bank'=>$bank->code,
                                        'adm_provision_fee'=>formatIDR( $application->administration_fee+$application->provision_fee)
                                    ]);
                                }
                            }
                        }else{
                            \Log::info('NO APPS');
                            $applications = Application::query()->readyForDropping($bank_id)->get();

                            foreach($applications as $application){
                                $application_id = $application->id;
                                $dropping_detail = new DroppingDetail;
                                $dropping_detail->dropping_id=$dropping->id;
                                $dropping_detail->application_id = $application_id;
                                $dropping_detail->save();
                                $application->status=2;
                                $application->disbursement_status = 'queue';
                                $application->dropping_id = $dropping->id;
                                $application->save();
                                $disbursement = Disbursement::whereApplicationId($application_id)->first();
                                $disbursement->dropping_id=$dropping->id;
                                $disbursement->status = 'queue';
                                $disbursement->save();
                                $total++;
                                $plafond += $application->plafon;
                                $cal_dropping = 0;
                                if($bank->code=='BPR SIP'){
                                    $cal_dropping = $application->plafon - ($application->administration_fee + $application->blockir_fee + $application->provision_fee);
                                }else{
                                    $cal_dropping = $application->plafon - ($application->administration_fee + $application->account_opening_fee + $application->provision_fee);
                                }
                                $total_dropping += $cal_dropping;
                                $taspen = Taspen::find($application->taspen_id);
                                $type = FinanceType::find($application->finance_type_id);
                                $total_adm_fee +=$application->administration_fee;
                                $total_block_installment += $application->blockir_fee;
                                $total_provision += $application->provision_fee;
                                $total_service_fee += $application->provision_fee;
                                $total_account_opening_fee += $application->account_opening_fee;
                                array_push($bank_applications, [
                                    'nopen'=>$taspen->nopen,
                                    'debitur'=>$taspen->name,
                                    'type'=>$type->name,
                                    'plafond'=>formatIDR($application->plafon),
                                    'adm_fee'=>formatIDR($application->administration_fee),
                                    'service_fee'=>formatIDR($application->provision_fee),
                                    'provision_fee'=>formatIDR($application->provision_fee),
                                    'interest'=> '1 Bulan',
                                    'block_installment'=>formatIDR($application->blockir_fee),
                                    'dropping'=>formatIDR( $cal_dropping),
                                    'account_opening_fee'=> formatIDR($application->account_opening_fee),
                                    'code_bank'=>$bank->code,
                                    'adm_provision_fee'=>formatIDR( $application->administration_fee+$application->provision_fee)
                                ]);
                            }
                        }


                        $data = [
                            'number'=>$dropping->number,
                            'debitur'=>$total,
                            'month'=>date('F', strtotime($dropping->date)),
                            'year'=>date('Y', strtotime($dropping->date)),
                            'receiver_name'=>$bank->name,
                            'plafond'=>formatIDR($plafond),
                            'dropping'=>formatIDR($total_dropping),
                            'account_number'=>env('APP_BANK_ACCOUNT_NUMBER'),
                            'account_name'=>env('APP_BANK_ACCOUNT_NAME'),
                            'bank_name'=>env('APP_BANK_NAME'),
                            'place_date'=>$branch_name.', '.date('d-m-Y', strtotime($dropping->date)),
                            'operational_chief'=>env('APP_DIRECTUR'),
                            'finance_manager'=>env('APP_FINANCE_MANAGER'),
                            'total_plafond'=>formatIDR($plafond),
                            'total_adm_fee'=>formatIDR($total_adm_fee),
                            'total_service_fee'=>formatIDR($total_service_fee),
                            'total_provision_fee'=>formatIDR($total_provision),
                            'total_interest'=>'',
                            'total_block_installment'=>formatIDR($total_block_installment),
                            'total_dropping'=>formatIDR($total_dropping),
                            'applications'=>$bank_applications,
                            'code_bank'=>$bank->code,
                            'total_account_opening_fee'=>formatIDR($total_account_opening_fee),
                            'total_adm_provision_fee'=>formatIDR($total_adm_fee+$total_provision)
                        ];

                        $pdf = Pdf::loadView('application.internal.contract', ['data'=>$data])->setPaper('a4')->setOptions(['enable_remote' => true, 'chroot' => public_path('img')]);
                        $file_name = 'DL-'.\Carbon\Carbon::now('UTC')->format('YmdHis') . '-' . str_replace(['/',' '],'_', $dropping->number);
                        $file_path = "documents/si/$dropping_id/$file_name";
                        $localStorage = Storage::disk('azure');
                        $localStorage->put($file_path, $pdf->output());
                        $dropping->file = $file_path;
                        $dropping->plafond = $plafond;
                        $dropping->dropping = $total_dropping;
                        $dropping->debitur = $total;
                        $dropping->status = 'queue';
                        $dropping->save();
                    }
                }
                \DB::commit();
                $response = ['status'=>'success','message'=>'success'];
            } catch (\Exception $e) {
                \DB::rollback();
                \Log::info('ERROR', ['file'=>$e->getFile(), 'line'=>$e->getLine(),'msg'=>$e->getMessage()]);
            }

        }

        return response()->json($response, 200);
    }


    /**
     * get datatable.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function datatableSIDisbursement(Request $request)
    {
        $data = Bank::siDataTable($request);
        return datatables()->of($data)
        ->addColumn('checkbox', function($row){
            return '<div class="icheck-primary d-inline">
                        <input type="checkbox" class="si-check bank-check" id="bank_'.$row->id.'" data-id="'.$row->id.'" name="bank['.$row->id.']">
                        <label for="bank_'.$row->id.'"></label>
                    </div>';
        })
        ->addColumn('data', function($row){
            $data = Application::query()->readyForDropping($row->id)
                ->addSelect('applications.id as id','applications.plafon as plafond','applications.account_opening_fee','applications.administration_fee as admin_bank')
                ->with(['taspen:id,nopen,name', 'product:id,name', 'financeType:id,name'])
                ->get()
                ->map(function($app){
                    $app->nopen = optional($app->taspen)->nopen;
                    $app->name = optional($app->taspen)->name;
                    $app->product_name = optional($app->product)->name;
                    $app->finance_type = optional($app->financeType)->name;
                    return $app;
                });
            return $data;
        })
        ->addIndexColumn()
        ->rawColumns([
            'data',
            'checkbox'
        ])
        ->make(true);
    }

    /**
     * get datatable.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function datatableDisbursement(Request $request)
    {
        $data = Dropping::dataTable($request);
        return datatables()->of($data)
        ->addColumn('upload_file', function($row){
            $url=route('application.internal.dropping-evidence.upload');
            $button = '<button type="button"  class="btn btn-default btn-upload-file" data-id="'.$row->id.'" data-title="UPLOAD SURAT PENCAIRAN '.$row->number.'"  data-url="'.$url.'"title="Upload"><i class="fas fa-upload"></i></button>';
            return $button;
        })
        ->addColumn('view_si', function($row){
            $url=generateSecureUrl($row->file);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-type="pdf" data-title="CETAK SURAT PENGAJUAN PENCAIRAN '.$row->number.'" class="btn btn-default view_file" data-id="'.$row->id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-print"></i></button>';
            if($row->file==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-print"></i></button>';
            }
            return $button;
        })
        ->addColumn('view_evidence', function($row){
            $url=generateSecureUrl($row->evidence);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-type="pdf" data-title="SURAT PENGAJUAN PENCAIRAN '.$row->number.'" class="btn btn-default view_file" data-id="'.$row->id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            if($row->evidence==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        ->addColumn('upload_transfer_evidence', function($row){
            $url=route('application.internal.bank-transfer.upload');
            $button = '<button type="button"  class="btn btn-default btn-upload-file" data-id="'.$row->id.'" data-title="UPLOAD BUKTI TRANSFER '.$row->number.'"  data-url="'.$url.'"title="Upload"><i class="fas fa-upload"></i></button>';
            return $button;
        })
        ->addColumn('view_transfer_evidence', function($row){
            $url=generateSecureUrl($row->transfer_evidence);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-type="pdf" data-title="BUKTI TRANSFER '.$row->number.'" class="btn btn-default view_file" data-id="'.$row->id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            if($row->transfer_evidence==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        // ->addColumn('view_nominative', function($row){
        //     $url=route('application.internal.files.Nominative', $row->id);
        //     $button = '<button type="button" data-title="Berkas Jaminan '.$row->name.'" class="btn btn-default btn-download" data-id="'.$row->id.'" data-url ="'.$url.'"><i class="fas fa-print"></i></button>';
        //     return $button;
        // })
        ->addColumn('status', function($row){
            $result='<span class="payment-status text-warning"><i><b>Antri</b></i></span>';
            if($row->status == 'on process'){
                $result='<span class="payment-status text-success"><i><b>Proses</b></i></span>';
            }else if($row->status == 'reject'){
                $result='<span class="payment-status text-danger"><i><b>Ditolak</b></i></span>';
            }else if($row->status == 'pending'){
                $result='<span class="payment-status text-warning"><i><b>Pending</b></i></span>';
            }else if($row->status == 'approve'){
                $result='<span class="payment-status text-success"><i><b>Selesai</b></i></span>';
            }

            return $result;
        })
        ->addColumn('submit_process', function($row){
            $url=route('application.internal.disbursement.approve');
            $status = 'on process';
            $class = 'disable';
            $button = '<button type="button" class="btn btn-success btn_submit_process '.$class.'" data-id="'.$row->id.'" data-status="'.$status.'" data-title="Proses Pencairan '.$row->number.'"  data-url="'.$url.'"title="Proses">Proses</button>';
            if($row->status == 'on process'){
                $button = '<button type="button" disabled class="btn btn-success btn_submit_process '.$class.'" data-id="'.$row->id.'" data-status="'.$status.'" data-title="Proses Pencairan '.$row->number.'"  data-url="'.$url.'"title="Proses">Proses</button>';
            }

            return $button;
        })
        ->addIndexColumn()
        ->rawColumns([
            'upload_file',
            'view_si',
            'view_evidence',
            'view_nominative',
            'upload_transfer_evidence',
            'view_transfer_evidence',
            'status',
            'submit_process'
        ])
        ->make(true);
    }

    /**
     * get datatable.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function datatableSecondDisbursement(Request $request)
    {
        $data = Application::disbursementDataTable($request);
        return datatables()->of($data)
        ->addColumn('upload_file', function($row){
            $url=route('application.internal.reception-evidence.upload');
            $button = '<button type="button"  class="btn btn-default btn-upload-file" data-id="'.$row->application_id.'" data-title="UPLOAD BERKAS PENERIMAAN BERSIH"  data-url="'.$url.'"title="Upload"><i class="fas fa-upload"></i></button>';
            return $button;
        })
        ->addColumn('view_evidence', function($row){
            $url=generateSecureUrl($row->reception_evidence);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-type="pdf" data-title="BERKAS PENERIMAAN BERSIH" class="btn btn-default view_file" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            if($row->reception_evidence==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        ->addIndexColumn()
        ->rawColumns([
            'upload_file',
            'view_evidence'
        ])
        ->make(true);
    }

    /**
     * get datatable.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function datatableDocument(Request $request)
    {
        $data = Application::documentDataTable($request);
        return datatables()->of($data)
        ->addColumn('action', function($row){
            return '';
            // $action = '<div class="text-center">
            //         <a href="'.route('application.internal.show', $row->application_id).'" class="btn btn-info btn-sm btn-md"><i class="fas fa-eye"></i> Detail</a>
            //     </div>';
            // return $action;
        })
        ->addColumn('upload_file', function($row){
            $button = '';
            $files = ApplicationFile::whereApplicationId($row->application_id)->first();
            if($files){
                $files = json_encode($files->toArray());
            }
            if($row->verification_status == 'approve' && $row->approval_status == 'approve' && $row->slik_status == 'approve'){
                $url=route('application.print.contract', $row->application_id);
                $button = "<button type='button'  data-toggle='modal' data-target='#modalUploadFiles' class='btn btn-default' data-id='".$row->application_id."' data-file ='".$files."'  data-url='".$url."'title='Upload'><i class='fas fa-upload'></i></button>";
            }
            return $button;
        })
        ->addColumn('riplay', function($row){
            $button = '';
            if($row->verification_status == 'approve' && $row->approval_status == 'approve' && $row->slik_status == 'approve'){
                $url='https://images.wondershare.com/recoverit/article/read_only_file.png';
                $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-type="img" data-title="Riplay '.$row->name.'" class="btn btn-default " data-id="'.$row->application_id.'" data-url ="'.$url.'" title="Upload"><i class="fas fa-upload"></i></button>';
            }
            if($row->akad==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        ->addColumn('view_akad', function($row){
            $url=generateSecureUrl($row->akad_file);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-type="pdf" data-title="Berkas Akad '.$row->name.'" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            if($row->akad_file==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        ->addColumn('view_settlement', function($row){
            $url=generateSecureUrl($row->settlement);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-type="video" data-title="Berkas Pelunasan '.$row->name.'" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            if($row->settlement==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        ->addColumn('view_guarantee', function($row){
            $url=generateSecureUrl($row->guarantee);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-title="Berkas Jaminan '.$row->name.'" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            if($row->guarantee==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        ->addColumn('view_account_bank', function($row){
            $url=generateSecureUrl($row->account_bank);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-title="Buku Tabungan '.$row->name.'" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            if($row->account_bank==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        ->addColumn('view_mutation', function($row){
            $url=generateSecureUrl($row->mutation);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-title="Berkas Mutasi  '.$row->name.'" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            if($row->mutation==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        ->addColumn('view_flagging', function($row){
            $url=generateSecureUrl($row->flagging);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-title="Berkas Flagging  '.$row->name.'" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            if($row->flagging==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        ->addColumn('view_disbursement', function($row){
            $url=generateSecureUrl($row->disbursement);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-title="Berkas Pencairan  '.$row->name.'" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            if($row->disbursement==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        ->addColumn('view_disbursement_video', function($row){
            $url=generateSecureUrl($row->disbursement_video);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-title="Video Perncairan  '.$row->name.'" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            if($row->disbursement_video==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        ->addColumn('view_disbursement_video_2', function($row){
            $url=generateSecureUrl($row->disbursement_video_2);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-title="Video Pencairan 2  '.$row->name.'" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            if($row->disbursement_video_2==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        ->addColumn('view_disbursement_video_3', function($row){
            $url=generateSecureUrl($row->disbursement_video_3);
            $button = '<button type="button" data-toggle="modal" data-target="#modalViewFile" data-title="Video Pencairan 3  '.$row->name.'" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            if($row->disbursement_video_3==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        ->addColumn('view_epotpen', function($row){
            $url=generateSecureUrl($row->epotpen);
            $button = '<button type="button"  data-toggle="modal" data-target="#modalViewFile" data-title="Berkas Epotpen  '.$row->name.'" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            if($row->epotpen==''){
                $button = '<button type="button" disabled data-toggle="modal" data-target="#modalViewFile" data-type="pdf" class="btn btn-default view_file" ><i class="fas fa-file"></i></button>';
            }
            return $button;
        })
        ->addColumn('view_application_file', function($row){
            $url=route('application.files.view', $row->application_id);
            $button = '<button type="button"  data-toggle="modal" data-target="#modalViewFile"  data-title="Berkas Pengajuan  '.$row->name.'" class="btn btn-default view_file" data-id="'.$row->application_id.'" data-url ="'.$url.'?type=application" title="Lihat Berkas"><i class="fas fa-file"></i></button>';
            return $button;
        })
        ->addIndexColumn()
        ->rawColumns([
            'action',
            'upload_file',
            'view_akad',
            'view_settlement',
            'view_guarantee',
            'view_account_bank',
            'view_mutation',
            'view_flagging',
            'view_disbursement',
            'view_disbursement_video',
            'view_disbursement_video_2',
            'view_disbursement_video_3',
            'view_epotpen',
            'view_application_file',
            'riplay'
        ])
        ->make(true);
    }


    public function viewFiles(Request $request, $id)
    {
        $documents = [];
        if(request('type')=='application'){
            $documents = Document::whereDocumentId($id)->whereNotNull('url')->groupBy('type')->orderBy('id','ASC')->get();
        }
        return view('application.internal.view-files', ['documents'=>$documents]);
        // return response()->json($view);
    }

    public function uploadFiles(Request $request){
        $rules = [
            'application_id'=>'required'
        ];

        if($request->hasFile('account_bank')){
            $rules['account_bank_number']='required';
            $rules['bank_name']='required';
        }

        $validate = validator($request->all(), $rules);

        if($validate->fails()){
            return response()->json(['message'=>$validate->errors(),'status'=>'error']);
        }
        try {
            DB::beginTransaction();
            $data = ApplicationFile::whereApplicationId($request->application_id)->first();
            if(!$data){
                $data = new ApplicationFile;
            }
            $today = \Carbon\Carbon::now('UTC');
            $data->application_id = $request->application_id;
            $application_id = $request->application_id;
            if(isset($request->deleted_files)){
                $deleted_files = explode(",",$request->deleted_files);
                foreach($deleted_files as $deleted_file){
                    if($deleted_file == 'account_bank'){
                        $data->account_bank_number = $request->account_bank_number;
                        $data->bank_name = $request->bank_name;
                        $data->account_bank = null;
                        $data->account_bank_date = null;
                    }else{
                        $data->{$deleted_file} = null;
                        $data->{$deleted_file.'_date'} = null;
                    }
                }
            }

            if($request->hasFile('account_bank')){
                $data->account_bank_number = $request->account_bank_number;
                $data->bank_name = $request->bank_name;
                $file = $request->account_bank;
                $original_name = $file->getClientOriginalName();
                $file_name = \Carbon\Carbon::now('UTC')->format('YmdHis') . '_' . $original_name;
                $file_path = "documents/$application_id/$file_name";
                $localStorage = Storage::disk('azure');
                $localStorage->put($file_path, file_get_contents($file));
                $data->account_bank = $file_path;
                $data->account_bank_date = $today;
            }
            if($request->hasFile('akad')){
                $file = $request->akad;
                $original_name = $file->getClientOriginalName();
                $file_name = \Carbon\Carbon::now('UTC')->format('YmdHis') . '_' . $original_name;
                $file_path = "documents/$application_id/$file_name";
                $localStorage = Storage::disk('azure');
                $localStorage->put($file_path, file_get_contents($file));
                $data->akad = $file_path;
                $data->akad_date = $today;
            }
            if($request->hasFile('settlement')){
                $file = $request->settlement;
                $original_name = $file->getClientOriginalName();
                $file_name = \Carbon\Carbon::now('UTC')->format('YmdHis') . '_' . $original_name;
                $file_path = "documents/$application_id/$file_name";
                $localStorage = Storage::disk('azure');
                $localStorage->put($file_path, file_get_contents($file));
                $data->settlement = $file_path;
                $data->settlement_date = $today;
            }
            if($request->hasFile('guarantee')){
                $file = $request->guarantee;
                $original_name = $file->getClientOriginalName();
                $file_name = \Carbon\Carbon::now('UTC')->format('YmdHis') . '_' . $original_name;
                $file_path = "documents/$application_id/$file_name";
                $localStorage = Storage::disk('azure');
                $localStorage->put($file_path, file_get_contents($file));
                $data->guarantee = $file_path;
                $data->guarantee_date = $today;
            }
            if($request->hasFile('mutation')){
                $file = $request->mutation;
                $original_name = $file->getClientOriginalName();
                $file_name = \Carbon\Carbon::now('UTC')->format('YmdHis') . '_' . $original_name;
                $file_path = "documents/$application_id/$file_name";
                $localStorage = Storage::disk('azure');
                $localStorage->put($file_path, file_get_contents($file));
                $data->mutation = $file_path;
                $data->mutation_date = $today;
            }
            if($request->hasFile('flagging')){
                $file = $request->flagging;
                $original_name = $file->getClientOriginalName();
                $file_name = \Carbon\Carbon::now('UTC')->format('YmdHis') . '_' . $original_name;
                $file_path = "documents/$application_id/$file_name";
                $localStorage = Storage::disk('azure');
                $localStorage->put($file_path, file_get_contents($file));
                $data->flagging = $file_path;
                $data->flagging_date = $today;
            }
            if($request->hasFile('epotpen')){
                $file = $request->epotpen;
                $original_name = $file->getClientOriginalName();
                $file_name = \Carbon\Carbon::now('UTC')->format('YmdHis') . '_' . $original_name;
                $file_path = "documents/$application_id/$file_name";
                $localStorage = Storage::disk('azure');
                $localStorage->put($file_path, file_get_contents($file));
                $data->epotpen = $file_path;
                $data->epotpen_date = $today;
            }
            if($request->hasFile('disbursement')){
                $file = $request->disbursement;
                $original_name = $file->getClientOriginalName();
                $file_name = \Carbon\Carbon::now('UTC')->format('YmdHis') . '_' . $original_name;
                $file_path = "documents/$application_id/$file_name";
                $localStorage = Storage::disk('azure');
                $localStorage->put($file_path, file_get_contents($file));
                $data->disbursement = $file_path;
                $data->disbursement_date = $today;
            }
            if($request->hasFile('disbursement_video')){
                $file = $request->disbursement_video;
                $original_name = $file->getClientOriginalName();
                $file_name = \Carbon\Carbon::now('UTC')->format('YmdHis') . '_' . $original_name;
                $file_path = "documents/$application_id/$file_name";
                $localStorage = Storage::disk('azure');
                $localStorage->put($file_path, file_get_contents($file));
                $data->disbursement_video = $file_path;
                $data->disbursement_video_date = $today;
            }
            if($request->hasFile('disbursement_video_2')){
                $file = $request->disbursement_video_2;
                $original_name = $file->getClientOriginalName();
                $file_name = \Carbon\Carbon::now('UTC')->format('YmdHis') . '_' . $original_name;
                $file_path = "documents/$application_id/$file_name";
                $localStorage = Storage::disk('azure');
                $localStorage->put($file_path, file_get_contents($file));
                $data->disbursement_video_2 = $file_path;
                $data->disbursement_video_2_date = $today;
            }
            if($request->hasFile('disbursement_video_3')){
                $file = $request->disbursement_video_3;
                $original_name = $file->getClientOriginalName();
                $file_name = \Carbon\Carbon::now('UTC')->format('YmdHis') . '_' . $original_name;
                $file_path = "documents/$application_id/$file_name";
                $localStorage = Storage::disk('azure');
                $localStorage->put($file_path, file_get_contents($file));
                $data->disbursement_video_3 = $file_path;
                $data->disbursement_video_3_date = $today;
            }

            $data->save();
            DB::commit();
            return response()->json(['message'=>'success','status'=>'success','data'=>$data]);
        } catch (\Exceptions $e) {
            DB::rollback();
            \Log::info('ERROR SAVED FILE');
            return response()->json(['message'=>$e->getMessage(),'status'=>'error']);
        }

    }

    public function uploadDroppingEvidence(Request $request){
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
                    $dropping_id = $request->id;
                    $dropping = Dropping::find($dropping_id);
                    $dropping->disbursement_date = \Carbon\Carbon::now('UTC');
                    $file = $request->file;
                    $original_name = $file->getClientOriginalName();
                    $file_name = 'SIGN-'.\Carbon\Carbon::now('UTC')->format('YmdHis') . '_' . $original_name;
                    $file_path = "documents/si/$dropping_id/$file_name";
                    $localStorage = Storage::disk('azure');
                    $localStorage->put($file_path, file_get_contents($file));
                    $dropping->evidence = $file_path;
                    $dropping->status = 'on process';
                    $dropping->save();
                    // Disbursement::where('dropping_id',$dropping->id)->update(['status'=>'on process']);
                    // Application::where('dropping_id',$dropping->id)->update(['disbursement_status'=>'on process']);
                }

                \DB::commit();
                $response = ['status'=>'success','message'=>'success'];
            } catch (\Exception $e) {
                \DB::rollback();
            }

        }

        return response()->json($response, 200);
    }

    public function uploadBankTransferEvidence(Request $request){
        \Log::info('sini');
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
                    $dropping_id = $request->id;
                    $dropping = Dropping::find($dropping_id);
                    $file = $request->file;
                    $original_name = $file->getClientOriginalName();
                    $file_name = 'TRF-'.\Carbon\Carbon::now('UTC')->format('YmdHis') . '-' . $original_name;
                    $file_path = "documents/si/$dropping_id/$file_name";
                    $localStorage = Storage::disk('azure');
                    $localStorage->put($file_path, file_get_contents($file));
                    $dropping->transfer_evidence = $file_path;
                    $dropping->transfer_date = \Carbon\Carbon::now('UTC');
                    $dropping->status = 'approve';
                    $dropping->save();
                    Disbursement::where('dropping_id',$dropping->id)->update(['status'=>'on process']);
                    Application::where('dropping_id',$dropping->id)->update(['disbursement_status'=>'on process']);
                }

                \DB::commit();
                $response = ['status'=>'success','message'=>'success'];
            } catch (\Exception $e) {
                \DB::rollback();
                \Log::info('ERROR',['file'=>$e->getFile(),'line'=>$e->getLine(),'msg'=>$e->getMessage()]);
            }

        }

        return response()->json($response, 200);
    }

    public function uploadReceptionEvidence(Request $request){
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
                    $application = Application::find($application_id);
                    $disbursement = Disbursement::whereApplicationId($application_id)->first();
                    $dropping_id = $disbursement->dropping_id;
                    $disbursement->reception_date = \Carbon\Carbon::now('UTC');
                    $file = $request->file;
                    $original_name = $file->getClientOriginalName();
                    $file_name = 'RCP-'.\Carbon\Carbon::now('UTC')->format('YmdHis') . '_' . $original_name;
                    $file_path = "documents/$application_id/$file_name";
                    $localStorage = Storage::disk('azure');
                    $localStorage->put($file_path, file_get_contents($file));
                    $disbursement->reception_evidence = $file_path;
                    $disbursement->status = 'approve';
                    $disbursement->save();
                    $application->disbursement_status = 'approve';
                    $application->save();
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
    public function disbursementApprove(Request $request){
        $validate = validator($request->all(), [
            'id'=>'required',
            'status'=>'required'
        ]);

        $response = ['status'=>'error','message'=>'error'];

        if($validate->fails()){
            $response = ['message'=>$validate->errors(),'status'=>'error'];
        }else{
            try {
                \DB::beginTransaction();
                $dropping = Dropping::find($request->id);
                $dropping->status = $request->status;
                $dropping->save();
                Disbursement::where('dropping_id',$dropping->id)->update(['status'=>$request->status]);
                Application::where('dropping_id',$dropping->id)->update(['disbursement_status'=>$request->status]);
                \DB::commit();
                $response = ['status'=>'success','message'=>'success'];
            } catch (\Exception $e) {
                \DB::rollback();
            }

        }

        return response()->json($response, 200);
    }
}
