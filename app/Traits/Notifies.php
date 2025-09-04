<?php

namespace App\Traits;

trait Notifies
{
    /**
     * Send a notification to the given user.
     *
     * @param string $title
     * @param string $message
     * @param string $status
     * @return void
     */
    public function notify(string $title = "Operacion exitosa", string $message = 'Todo salio sin percances', string $status = '200'): void
    {
        // Implement notification logic here
        // Example: $user->notify(new NotificationClass($message));
        $this->dispatch('show-notification', [
            'title'   => $title,
            'message' => $message,
            'status' => $status
        ]);
    }
}
