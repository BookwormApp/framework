<?php

namespace Bookworm\Events;

use App\Events\Event;
use Bookworm\Users\User;
use Illuminate\Queue\SerializesModels;

class UserCreated extends Event
{
    use SerializesModels;

    protected $user;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
