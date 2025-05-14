<?php

// app/Notifications/StokBarangMenipis.php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class StokBarangMenipis extends Notification
{
    public $barang;

    public function __construct($barang)
    {
        $this->barang = $barang;
    }

    public function via($notifiable)
    {
        return ['broadcast'];
    }

    public function broadcastOn()
    {
        return new Channel('barang-channel');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->barang['id'],
            'nama' => $this->barang['nama'],
            'jumlah' => $this->barang['jumlah'],
            'jumlah_beli' => $this->barang['jumlah_beli'],
        ];
    }
}

