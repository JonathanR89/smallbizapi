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

    protected $userData;

    public function __construct($userData)
    {
        //
        echo "handle";
        $this->userData = $userData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo "handle";
        var_dump($this->userData);
        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);

        $beautymail->send('Email.FollowUpEmail', [],
       function ($message) {
           $message
           ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
            ->to("dnorgarb@gmail.com", "cd")
            ->to($this->userData['email'], $this->userData['name'])
           ->subject("CRM Consulting Enquiry");
       });
    }
}
