<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationSend implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $message;

	/**
	 * Create a new event instance.
	 */
	public function __construct($message)
	{
		$this->message = $message;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return array<int, \Illuminate\Broadcasting\Channel>
	 */
	public function broadcastOn(): array
	{
		return [
			new PrivateChannel('notifications.' . $this->message['to']),
		];
	}
}
