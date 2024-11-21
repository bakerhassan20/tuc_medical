<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookNotification extends Notification
{
    use Queueable;

    protected $book_id;
    protected $type;
    public function __construct($book_id,$type)
    {
        $this->book_id=$book_id;
        $this->type=$type;
    }

    public function via($notifiable)
    {
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        return [
            'book_id' => $this->book_id,
            'type' => $this->type,
        ];
    }
}
