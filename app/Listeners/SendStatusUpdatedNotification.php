<?php

namespace App\Listeners;

use App\Models\User;
use App\Models\Notification;
use App\Events\NewsStatusUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendStatusUpdatedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewsStatusUpdated $event): void
    {
        // Send notification to Author if status updated
        $author = $event->news->author;
        
        Notification::create([
            'user_id' => $author->id,
            'data' => $event->news->title . ' has been updated to ' . $event->news->status,
            'read_at' => null,
        ]);
    }
}
