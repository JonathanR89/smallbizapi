<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendFollowUpEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        echo "handle";
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo "handle";
        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);

        $beautymail->send('Email.FollowUpEmail', [],
       function ($message) {
           $message
           ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
            ->to("dnorgarb@gmail.com", "cd")
           // ->to("perry@smallbizcrm.com", "No email record in DB for this referral")
           // ->to("perry@smallbizcrm.com", "")
           ->subject("Test Queue");
       });
    }
}
