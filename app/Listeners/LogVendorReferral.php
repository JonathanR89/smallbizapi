<?php

namespace App\Listeners;

use DB;
use App\Events\VendorRefferal;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogVendorReferral
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  VendorRefferal  $event
     * @return void
     */
    public function handle(VendorRefferal $event)
    {
        $vendor = $event;
        dd($event);
        DB::table('email_log')->insert([
          'date' => date('Y-m-d H:i:s'),
          'to' => $message->getHeaders()->get('To')->getFieldBody(),
          'subject' => $message->getHeaders()->get('Subject')->getFieldBody(),
          'body' => utf8_encode($this->getMimeEntityString($message)),
      ]);
    }
}
