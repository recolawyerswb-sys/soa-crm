<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected Client $client;
    protected string $from;

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $this->from = config('services.twilio.from');
        $this->client = new Client($sid, $token);
    }

    public function sendSms(string $to, string $message): void
    {
        $this->client->messages->create($to, [
            'from' => $this->from,
            'body' => $message,
        ]);
    }

    public function makeCall(string $to, string $url, string $statusCallback): string
    {
        $call = $this->client->calls->create(
            $to,
            $this->from,
            [
                "url" => $url,
                "statusCallback" => $statusCallback,
                "statusCallbackEvent" => ["initiated", "ringing", "answered", "completed"],
                "statusCallbackMethod" => "POST",
            ]
        );

        return $call->sid; // para poder rastrear luego duración, estado, etc.
    }
}
