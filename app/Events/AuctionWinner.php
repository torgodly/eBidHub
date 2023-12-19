<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuctionWinner implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $auction_id;

    /**
     * Create a new event instance.
     */
    public function __construct($user_id, $auction_id)
    {
        $this->user_id = $user_id;
        $this->auction_id = $auction_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
//     * //     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return ['AuctionWinner-channel'];
    }

    public function broadcastAs()
    {
        return 'AuctionWinner-event';
    }
}
