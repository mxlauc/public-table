<?php

namespace App\Listeners;

use App\Events\NewCommentLike;
use App\Notifications\NewCommentLike as NotificationsNewCommentLike;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewCommentLikeNotification
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
     * @param  NewCommentLike  $event
     * @return void
     */
    public function handle(NewCommentLike $event)
    {
        $event->post->user->notify(new NotificationsNewCommentLike($event->post, $event->user));
    }
}
