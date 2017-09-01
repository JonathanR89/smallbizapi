<?php

namespace App\Events;

use App\VendorRefferal;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class VendorRefferalSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $AirtableData;
    public $submissionData;

    public function __construct($submissionData, $AirtableData)
    {
        $this->submissionData = $submissionData;
        $this->AirtableData = $AirtableData;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
