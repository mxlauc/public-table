<?php

namespace App\Listeners;

use App\Events\NewLike;
use App\Notifications\NewLike as NotificationsNewLike;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewLikeNotification
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
     * @param  NewLike  $event
     * @return void
     */
    public function handle(NewLike $event)
    {
        $event->post->user->notify(new NotificationsNewLike($event->post, $event->user));
    }
}
