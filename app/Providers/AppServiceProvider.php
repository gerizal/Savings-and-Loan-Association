<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Strict mode in development — catches N+1 queries and lazy loading issues
        Model::shouldBeStrict(! app()->isProduction());

        // Disable wrapping of JSON resources
        JsonResource::withoutWrapping();

        // Log slow queries in production (> 2 seconds)
        if (app()->isProduction()) {
            DB::whenQueryingForLongerThan(2000, function () {
                \Illuminate\Support\Facades\Log::warning('Slow query detected', [
                    'queries' => DB::getQueryLog(),
                ]);
            });
        }
    }
}
