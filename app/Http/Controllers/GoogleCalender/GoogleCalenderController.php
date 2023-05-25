<?php

namespace App\Http\Controllers\GoogleCalender;

use App\Http\Controllers\Controller;
use App\Concern\GoogleCalenderService;
use Illuminate\Http\Request;

class GoogleCalenderController extends Controller
{
    public function __construct(protected GoogleCalenderService $googleCalender) {}

    public function getConsentScreen()
    {
        return $this->googleCalender->fetchGoogleConsentScreen();
    }

    public function handleCallback(Request $request)
    {
        $accessToken = $this->googleCalender->replaceCodeWithAccessToken($request->code);

        if ($accessToken) {
            auth()->user()->forceFill(['access_token' => $accessToken])->save();
        }

        return redirect(route('meeting.create'));
    }
}
