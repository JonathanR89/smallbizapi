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
      // 'App\Events\MailSent' => [
      //     'App\Listeners\LogMailSent',
      // ],
      MessageSending::class => [
        \App\Listeners\LogMailSent::class,
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

    //     Event::listen('event.name', function ($foo, $bar) {
    // //
    //   });
    }
}
