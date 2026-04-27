<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Application;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportExport implements FromView
{
    protected $filter;
    protected $type;

    public function __construct($filter, $type)
    {
        $this->filter = $filter;
        $this->type   = $type;
    }

    public function view(): View
    {
        if ($this->type == 'cash-flow') {
            return view('exports.report-cash-flow', [
                'data' => Application::reportCashFlow($this->filter)
            ]);
        }

        if ($this->type == 'outstanding') {
            return view('exports.report-outstanding', [
                'data' => Application::reportOutstanding($this->filter)
            ]);
        }

        if ($this->type == 'debtor') {
            return view('exports.report-debtor', [
                'data' => Application::reportDebtor($this->filter)
            ]);
        }

        return view('exports.report', [
            'data' => Application::report($this->filter)->get()
        ]);
    }
}
