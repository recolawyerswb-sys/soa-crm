<?php

namespace App\Http\Controllers\Communications\Calls;
\
use App\Http\Controllers\Controller;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use Twilio\TwiML\VoiceResponse;

class CallController extends Controller
{
    public function makeCall(string $number): string
    {
        $url = route('twilio.voice'); // endpoint TwiML
        return app(TwilioService::class)->makeCall($number, $url);
    }
}
