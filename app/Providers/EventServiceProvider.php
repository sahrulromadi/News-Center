<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\NewsCreated;
use App\Listeners\SendNewsNotification;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        NewsCreated::class => [
            SendNewsNotification::class,
        ],
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        parent::boot();
    }
}
