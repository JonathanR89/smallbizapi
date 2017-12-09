<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendFollowUpCRMFinderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userData;

    public function __construct($userData)
    {
        $this->userData = $userData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // echo "here";
        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('Email.FollowUpCRMFinderEmail', ['name' => $this->userData['name'], 'submission_id' => $this->userData['submission_id']],
        function ($message) {
            $message
          ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
          ->to($this->userData['email'], $this->userData['name'] ? $this->userData['name'] : " ")
          ->to("devin@smallbizcrm.com", "SmallBizCRM.com")
          ->to("theresa@smallbizcrm.com", "SmallBizCRM.com")
          ->to("perry@smallbizcrm.com", "SmallBizCRM.com")
          ->subject("CRM Enquiry");
        });
    }
}
