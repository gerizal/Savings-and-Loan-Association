<?php

namespace App\Jobs;

use App\Exports\ReportExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class GenerateReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 300;
    public int $tries = 3;

    public function __construct(
        private readonly array $filters,
        private readonly ?string $type,
        private readonly string $filename,
        private readonly int $userId,
    ) {}

    public function handle(): void
    {
        $request = new \Illuminate\Http\Request();
        $request->replace($this->filters);

        $path = "reports/{$this->filename}";
        Excel::store(new ReportExport($request, $this->type), $path, 'local');

        \Illuminate\Support\Facades\Cache::put(
            "report_ready:{$this->userId}:{$this->filename}",
            Storage::url($path),
            now()->addHours(2)
        );
    }

    public function failed(\Throwable $e): void
    {
        \Illuminate\Support\Facades\Log::error('GenerateReportJob failed', [
            'user_id'  => $this->userId,
            'filename' => $this->filename,
            'error'    => $e->getMessage(),
        ]);
    }
}
