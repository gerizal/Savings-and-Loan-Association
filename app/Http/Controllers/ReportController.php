<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateReportJob;
use App\Models\Application;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('role.feature.check:laporan,view', ['only' => ['index']]);
        $this->middleware('role.feature.check:laporan,create', [
            'only' => ['generateReport', 'generateReportCashFlow', 'generateReportOutstanding', 'generateReportDebtor', 'checkReportStatus'],
        ]);
    }

    public function index()
    {
        $banks = Bank::select('id', 'name')->get();
        return view('report.index', compact('banks'));
    }

    public function dataTable(Request $request)
    {
        return datatables()->of(Application::report($request))->addIndexColumn()->make(true);
    }

    public function generateReport(Request $request)
    {
        return $this->dispatchReport($request, null, 'report.xlsx');
    }

    public function generateReportCashFlow(Request $request)
    {
        $this->applyBankFilter($request);
        return $this->dispatchReport($request, 'cash-flow', 'report-cash-flow.xlsx');
    }

    public function generateReportOutstanding(Request $request)
    {
        $this->applyBankFilter($request);
        return $this->dispatchReport($request, 'outstanding', 'report-outstanding.xlsx');
    }

    public function generateReportDebtor(Request $request)
    {
        $this->applyBankFilter($request);
        return $this->dispatchReport($request, 'debtor', 'report-debtor.xlsx');
    }

    public function checkReportStatus(Request $request)
    {
        $filename = $request->string('filename');
        $url      = Cache::get("report_ready:{$request->user()->id}:{$filename}");

        return response()->json([
            'ready' => (bool) $url,
            'url'   => $url,
        ]);
    }

    public function cashFlow()
    {
        return view('report.cash-flow', ['banks' => Bank::select('id', 'name')->get()]);
    }

    public function cashFlowDataTable(Request $request)
    {
        $this->applyBankFilter($request);
        return datatables()->of(Application::reportCashFlow($request))->addIndexColumn()->make(true);
    }

    public function outstanding()
    {
        return view('report.outstanding', ['banks' => Bank::select('id', 'name')->get()]);
    }

    public function outstandingDataTable(Request $request)
    {
        $this->applyBankFilter($request);
        return datatables()->of(Application::reportOutstanding($request))->addIndexColumn()->make(true);
    }

    public function monthly()
    {
        return view('report.monthly', ['banks' => Bank::select('id', 'name')->get()]);
    }

    public function monthlyDataTable(Request $request)
    {
        return datatables()->of(Application::reportMonthly($request))->addIndexColumn()->make(true);
    }

    public function fixedCost()
    {
        return view('report.fixed-cost', ['banks' => Bank::select('id', 'name')->get()]);
    }

    public function fixedCostDataTable(Request $request)
    {
        return datatables()->of(Application::reportFixedCost($request))
            ->addColumn('action', fn($row) => '<div class="text-center"><a href="#" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Detail</a></div>')
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function alternativeCost()
    {
        return view('report.alternative-cost', ['banks' => Bank::select('id', 'name')->get()]);
    }

    public function alternativeCostDataTable(Request $request)
    {
        return datatables()->of(Application::reportAlternativeCost($request))
            ->addColumn('action', fn($row) => '<div class="text-center"><a href="#" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Detail</a></div>')
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function insurance()
    {
        return view('report.insurance', ['banks' => Bank::select('id', 'name')->get()]);
    }

    public function insuranceDataTable(Request $request)
    {
        return datatables()->of(Application::reportInsurance($request))
            ->addColumn('action', fn($row) => '<div class="text-center"><a href="#" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Detail</a></div>')
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function debtor()
    {
        return view('report.debtor', ['banks' => Bank::select('id', 'name')->get()]);
    }

    public function debtorDataTable(Request $request)
    {
        $this->applyBankFilter($request);
        return datatables()->of(Application::reportDebtor($request))->addIndexColumn()->make(true);
    }

    private function dispatchReport(Request $request, ?string $type, string $filename): \Illuminate\Http\JsonResponse
    {
        $userId = Auth::id();
        GenerateReportJob::dispatch($request->all(), $type, $filename, $userId)->onQueue('reports');

        return response()->json([
            'queued'   => true,
            'filename' => $filename,
            'message'  => 'Laporan sedang diproses. Silakan cek kembali dalam beberapa saat.',
        ]);
    }

    private function applyBankFilter(Request $request): void
    {
        $user      = Auth::user();
        $user_role = user_role();
        if ($user_role && $user_role->slug === 'bank') {
            $request->merge(['bank' => $user->bank_id]);
        }
    }
}
