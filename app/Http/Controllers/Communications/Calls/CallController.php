<?php

namespace App\Http\Controllers\Communications\Calls;

use App\Http\Controllers\Controller;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use Twilio\TwiML\VoiceResponse;

class CallController extends Controller
{
    public function makeCall(string $number): string
    {
        $url = route('sells.calls.twilio.voice'); // endpoint TwiML
        $statusCallback = route('twilio.status');
        return app(TwilioService::class)->makeCall($number, $url, $statusCallback);
    }
}
