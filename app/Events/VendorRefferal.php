<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class VendorRefferal
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $vendor;

    public function __construct(VendorRefferal $vendor)
    {
        $this->vendor = $vendor;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
