<?php

namespace App\Jobs;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProcessApplicationStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 60;
    public int $tries = 3;

    public function __construct(
        private readonly int $applicationId,
        private readonly string $status,
        private readonly ?string $previousStatus = null,
    ) {}

    public function handle(): void
    {
        $application = Application::with(['taspen', 'product', 'bank'])->find($this->applicationId);

        if (! $application) {
            return;
        }

        // Invalidate any cached data related to this application
        Cache::forget("application:{$this->applicationId}");
        Cache::forget("access:" . optional($application->marketing)->id . ":*");

        Log::info('Application status changed', [
            'application_id'  => $this->applicationId,
            'previous_status' => $this->previousStatus,
            'new_status'      => $this->status,
        ]);
    }

    public function failed(\Throwable $e): void
    {
        Log::error('ProcessApplicationStatusJob failed', [
            'application_id' => $this->applicationId,
            'status'         => $this->status,
            'error'          => $e->getMessage(),
        ]);
    }
}
