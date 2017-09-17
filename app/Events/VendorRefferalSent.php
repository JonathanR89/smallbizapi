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
    public $vendor;
    public $submissionData;

    public function __construct($submissionData, $vendor)
    {
        $this->submissionData = $submissionData;
        $this->vendor = $vendor;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
