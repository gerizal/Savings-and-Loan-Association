<?php

use Laravel\Octane\Contracts\OperationTerminated;
use Laravel\Octane\Events\RequestHandled;
use Laravel\Octane\Events\RequestReceived;
use Laravel\Octane\Events\RequestTerminated;
use Laravel\Octane\Events\TaskReceived;
use Laravel\Octane\Events\TaskTerminated;
use Laravel\Octane\Events\TickReceived;
use Laravel\Octane\Events\TickTerminated;
use Laravel\Octane\Events\WorkerErrorOccurred;
use Laravel\Octane\Events\WorkerStarting;
use Laravel\Octane\Events\WorkerStopping;
use Laravel\Octane\Listeners\CollectGarbage;
use Laravel\Octane\Listeners\DisconnectFromDatabases;
use Laravel\Octane\Listeners\EnsureUploadedFilesAreValid;
use Laravel\Octane\Listeners\EnsureRequestIsNotOversized;
use Laravel\Octane\Listeners\FlushAuthenticationState;
use Laravel\Octane\Listeners\FlushQueuedCookies;
use Laravel\Octane\Listeners\FlushSessionState;
use Laravel\Octane\Listeners\FlushTemporaryContainerInstances;
use Laravel\Octane\Listeners\GiveNewApplicationInstanceToQueue;
use Laravel\Octane\Listeners\GiveNewApplicationInstanceToRouter;
use Laravel\Octane\Listeners\ReportException;
use Laravel\Octane\Listeners\StopWorkerIfNecessary;
use Laravel\Octane\Listeners\WriteExceptionToStderr;
use Laravel\Octane\Listeners\WriteRequestToLog;
use Laravel\Octane\Octane;

return [

    'server' => env('OCTANE_SERVER', 'swoole'),

    'https' => env('OCTANE_HTTPS', false),

    'listeners' => [
        WorkerStarting::class => [
            EnsureUploadedFilesAreValid::class,
        ],

        RequestReceived::class => [
            ...Octane::prepareApplicationForNextOperation(),
            EnsureRequestIsNotOversized::class,
        ],

        RequestHandled::class => [
            WriteRequestToLog::class,
        ],

        RequestTerminated::class => [
            FlushTemporaryContainerInstances::class,
            DisconnectFromDatabases::class,
            CollectGarbage::class,
        ],

        TaskReceived::class => [
            ...Octane::prepareApplicationForNextOperation(),
        ],

        TaskTerminated::class => [
            FlushTemporaryContainerInstances::class,
            DisconnectFromDatabases::class,
            CollectGarbage::class,
        ],

        TickReceived::class => [
            ...Octane::prepareApplicationForNextOperation(),
        ],

        TickTerminated::class => [
            FlushTemporaryContainerInstances::class,
            DisconnectFromDatabases::class,
            CollectGarbage::class,
        ],

        OperationTerminated::class => [
            FlushQueuedCookies::class,
            FlushSessionState::class,
            FlushAuthenticationState::class,
            GiveNewApplicationInstanceToQueue::class,
            GiveNewApplicationInstanceToRouter::class,
            StopWorkerIfNecessary::class,
        ],

        WorkerErrorOccurred::class => [
            ReportException::class,
            StopWorkerIfNecessary::class,
        ],

        WorkerStopping::class => [
            //
        ],
    ],

    'warm' => [
        ...Octane::defaultServicesToWarm(),
    ],

    'flush' => [],

    'garbage' => 50,

    'max_execution_time' => 30,

    'tick_interval' => 1000,

    'swoole' => [
        'options' => [
            'log_file' => storage_path('logs/swoole_http.log'),
            'package_max_length' => 10 * 1024 * 1024,
            'worker_num' => env('SWOOLE_WORKERS', swoole_cpu_num() * 2),
            'task_worker_num' => env('SWOOLE_TASK_WORKERS', swoole_cpu_num()),
            'max_request' => env('SWOOLE_MAX_REQUESTS', 1000),
        ],
    ],

    'roadrunner' => [
        'via' => Laravel\Octane\RoadRunner\ServerProcessInspector::class,
    ],

    'vapid' => [
        'public_key' => env('VAPID_PUBLIC_KEY', ''),
        'private_key' => env('VAPID_PRIVATE_KEY', ''),
    ],

];
