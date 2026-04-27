<?php

namespace App\Jobs;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GeneratePdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 120;
    public int $tries = 3;

    public function __construct(
        private readonly string $view,
        private readonly array $data,
        private readonly string $filename,
        private readonly int $userId,
    ) {}

    public function handle(): void
    {
        $pdf  = Pdf::loadView($this->view, $this->data);
        $path = "pdfs/{$this->filename}";

        Storage::put($path, $pdf->output());

        Cache::put(
            "pdf_ready:{$this->userId}:{$this->filename}",
            Storage::url($path),
            now()->addHours(2)
        );
    }

    public function failed(\Throwable $e): void
    {
        Log::error('GeneratePdfJob failed', [
            'user_id'  => $this->userId,
            'view'     => $this->view,
            'filename' => $this->filename,
            'error'    => $e->getMessage(),
        ]);
    }
}
