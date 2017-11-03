<?php

namespace App\Listeners;

use DB;
use App\Events\MailSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Events\MessageSending;

class LogMailSent
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
     * @param  MailSent  $event
     * @return void
     */
    public function handle(MessageSending $event)
    {
        $message = $event->message;

        DB::table('email_log')->insert([
          'date' => date('Y-m-d H:i:s'),
          'to' => $message->getHeaders()->get('To')->getFieldBody(),
          'subject' => $message->getHeaders()->get('Subject')->getFieldBody(),
          'body' => utf8_encode($this->getMimeEntityString($message)),
      ]);
    }

    /**
     * Get a loggable string out of a Swiftmailer entity.
     *
     * @param  \Swift_Mime_MimeEntity $entity
     * @return string
     */
    public function getMimeEntityString($entity)
    {
        $string = (string) $entity->getHeaders().PHP_EOL.$entity->getBody();
        $compressedGZ = gzdeflate($string, 9);
        $compressed = gzcompress($string, 9);
        return $compressed;
    }
}
