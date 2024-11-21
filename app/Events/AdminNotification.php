<?php
namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $username;
    public $message;



    public function __construct($username,$message)
    {
        $this->username = $username;
        $this->message = $message;

    }

     public function broadcastOn()
    {
        return ['status-liked'];
    }

    public function broadcastAs()
    {
        return 'noyify';
    }
}


