<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Mail\Events\MessageSending;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
      MessageSending::class => [
        \App\Listeners\LogMailSent::class,
      ],
      \App\Events\VendorRefferal::class => [
        \App\Listeners\LogVendorReferral::class,
      ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
