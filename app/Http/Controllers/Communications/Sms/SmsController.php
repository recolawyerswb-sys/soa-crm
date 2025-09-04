<?php

namespace App\Http\Controllers\Communications\Sms;

use App\Http\Controllers\Controller;
use App\Services\TwilioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class SmsController extends Controller
{
    protected TwilioService $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }

    public function send(string $number, string $message): void
    {
        $this->twilio->sendSms($number, $message);
    }
}
