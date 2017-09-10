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

    public function __construct()
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
        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('Email.FollowUpConsultantFinderEmail', [],
      function ($message) {
          $message
        ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
        ->to("devin@smallbizcrm.com", "SmallBizCRM.com")
        ->to($this->userData['email'], $this->userData['name'])
        ->subject("CRM Consulting Enquiry");
      });
    }
}
