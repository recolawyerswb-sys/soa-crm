<?php

namespace App\Events\Models;

use App\Models\Customer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CustomerDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(Customer $model)
    {
        DB::transaction(function () use ($model) {
            if ($model->profile && $model->profile->user && $model->profile->user->wallet) {
                foreach ($model->profile->user->wallet->movements as $movement) {
                    $movement->delete();
                }

                $model->profile->user->wallet->delete();
                $model->profile->user->delete();
                $model->profile->delete();
            }

            if ($model->assignment) {
                $model->assignment->delete();
            }

            $model->delete();
        });
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
