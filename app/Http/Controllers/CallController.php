<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\TwiML\VoiceResponse;

class CallController extends Controller
{
    public static function testCall($customer)
    {
        $reponse = new VoiceResponse();
        $reponse->say("Hello, this is a test call from SOA CRM.");

        dd($reponse);
    }

    public static function testSms($number)
    {
        return back()->with('status', "Mensaje enviado a {$number}");
    }
}
