<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Bank;
use App\Models\Product;
use App\Models\FinanceType;
use App\Models\Approval;
use App\Models\Verification;
use App\Models\Disbursement;
use App\Models\Dropping;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\BranchUnit;
use App\Models\ServiceUnit;
use App\Models\User;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('role.feature.check:dashboard,view', ['only' => ['index']]);
    }
    public function index(Request $request){
        try {
            $user = \Auth::user();
            $user_role = user_role();

            // Redirect specific roles
            if($user_role){
                // role_id 4 = Approval Bank → redirect to /application/loan
                if($user_role->id == 4){
                    return redirect('/application/loan');
                }
                // role_id 5 = Slik Bank → redirect to /application/slik
                if($user_role->id == 5){
                    return redirect('/application/slik');
                }
                // role_id 9 = Verifikasi → redirect to /application/verification
                if($user_role->id == 9){
                    return redirect('/application/verification');
                }
            }

            $whereRaw1 = '1=1';
            if($user_role && ($user_role->slug=='bank')){
                $whereRaw1 = "id = 0"; // ignore unknown user-bank
                if($user && $user->bank_id) {
                    $whereRaw1 = "id = $user->bank_id";
                }
            }

            $banks = Bank::select('id','name')->whereRaw($whereRaw1)->get();
            $months = collect([]);
            $periods = CarbonPeriod::create(Carbon::now()->startOfYear(), '1 month', Carbon::now());
            foreach ($periods as $period) {
                $months->push($period->format('M'));
            }
            $chart_data = [];
            $color = hexColor();
            foreach($banks as $key => $bank){
                $data = Application::selectRaw("sum(plafon) as total,date_format(created_at, '%b') as period")
                    ->whereYear('created_at', '>=', Carbon::now()->format('Y'))
                    ->where('bank_id', $bank->id)
                    ->groupBy('period')
                    ->get()
                    ->keyBy('period')
                    ->toArray();

                $totals = [];
                foreach($months as $month){
                    $total = isset($data[$month]) ? $data[$month]['total'] : 0;
                    array_push($totals, $total);

                }

                $_chart_data = [
                    'label'               => $bank->name,
                    'backgroundColor'     => $color[$key],
                    'borderColor'         => $color[$key],
                    'pointRadius'         => true,
                    'pointColor'          => '#3b8bba',
                    'pointStrokeColor'    => $color[$key],
                    'pointHighlightFill'  => '#fff',
                    'pointHighlightStroke'=> $color[$key],
                    'data'                => $totals
                ];

                array_push($chart_data, $_chart_data);
            }

            $queue = Application::select("plafon")->whereYear('created_at', '>=', Carbon::now()->format('Y'))->where('status', 1)->get()->sum('plafon');
            $dropping = Application::select("plafon")->whereYear('created_at', '>=', Carbon::now()->format('Y'))->where('status', 2)->get()->sum('plafon');
            $reject = Application::select("plafon")->whereYear('created_at', '>=', Carbon::now()->format('Y'))->where('status', 5)->get()->sum('plafon');

            $chart_data = [
                'labels'=>$months,
                'datasets'=>$chart_data
            ];

            $donut_chart = [
                'labels'=>[
                    'Dropping',
                    'Antri',
                    'Ditolak',
                ],
                'datasets'=>[
                    [
                        'data'=> [$dropping, $queue, $reject],
                        'backgroundColor' => ['#00FFFF', '#00FF00', '#FF0000'],
                    ]
                ]
            ];

            return view('index', compact('chart_data','donut_chart'));
        } catch (\Exception $e) {
            \Log::error('Error on Home Dashboard: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return view('index', [
                'chart_data' => ['labels'=>[], 'datasets'=>[]],
                'donut_chart' => ['labels'=>[], 'datasets'=>[]]
            ]);
        }
    }

    public function regularBankDataTable(Request $request){
        $data = Bank::dashboard(0);
        return datatables()->of($data)
        ->addColumn('new_data', function($row){
            return '';
        })->make(true);

    }

    public function flashBankDataTable(Request $request){
        $data = Bank::dashboard(1);
        return datatables()->of($data)
        ->addColumn('new_data', function($row){
            return '';
        })->make(true);
    }

    public function areaDataTable(Request $request){
        $data = ServiceUnit::dashboard();
        return datatables()->of($data)
        ->addColumn('total_queue', function($row){
            return $row->count_queue.' | '. $row->total_queue;
        })
        ->addColumn('total_disbursement', function($row){
            return $row->count_disbursement.' | '. $row->total_disbursement;
        })->make(true);

    }

    public function branchDataTable(Request $request){
        $data = BranchUnit::dashboard();
        return datatables()->of($data)
        ->addColumn('total_queue', function($row){
            return $row->count_queue.' | '. $row->total_queue;
        })
        ->addColumn('total_disbursement', function($row){
            return $row->count_disbursement.' | '. $row->total_disbursement;
        })->make(true);
    }

    public function marketingDataTable(Request $request){
        $data = User::dashboard();
        return datatables()->of($data)
        ->make(true);
    }
}
