<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Route;

class SendNewsNotification
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
    public function handle(object $event): void
    {
        // Send notification to Editor if news is created or updated
        $editors = User::role('Editor')->get();

        $routeName = Route::currentRouteName();
        $title = $event->news->title;
        $message = '';

        if ($routeName == 'news.store') {
            $message = "$title has been created.";
        } elseif ($routeName == 'news.update') {
            $message = "$title has been updated.";
        }

        foreach ($editors as $editor) {
            Notification::create([
                'user_id' => $editor->id,
                'data' => $message,
                'read_at' => null,
            ]);
        }
    }
}
