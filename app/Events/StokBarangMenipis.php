<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Barang;

class StokBarangMenipis implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public $barang;

    public function __construct(array $barang)
    {
        $this->barang = $barang;
    }

    public function broadcastOn()
    {
        return new Channel('barang-channel');
    }

    public function broadcastWith()
    {
        return $this->barang;
    }
}
