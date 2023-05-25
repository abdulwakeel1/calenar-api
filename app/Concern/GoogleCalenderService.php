<?php

namespace App\Concern;

class GoogleCalenderService
{
    public function fetchGoogleConsentScreen()
    {
        $clientID = config('services.google-calendar.client_id');
        $redirectURI = config('services.google-calendar.redirect'); 
        $scope = 'https://www.googleapis.com/auth/calendar'; 

        $authURL = 'https://accounts.google.com/o/oauth2/auth';
        $params = [
            'client_id' => $clientID,
            'redirect_uri' => $redirectURI,
            'response_type' => 'code',
            'scope' => $scope,
            'access_type' => 'offline', 
        ];

        $authURL .= '?' . http_build_query($params);

        header('Location: ' . $authURL);
        exit;
    }

    public function replaceCodeWithAccessToken($code)
    {
        $accessTokenData = $accessToken = null;

        $clientID = config('services.google-calendar.client_id');
        $clientSecret = config('services.google-calendar.client_secret'); 
        $redirectURI = config('services.google-calendar.redirect');

        $url = 'https://oauth2.googleapis.com/token';

        $data = [
            'code' => $code,
            'client_id' => $clientID,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectURI,
            'grant_type' => 'authorization_code',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);


        if ($response) {
            $accessTokenData = json_decode($response, true);
            $accessToken = $accessTokenData['access_token'];
        } else {
            echo null;
        }

        return $accessToken;
    }

    public function saveMeetingInGoogleCalendar($request)
    {
        $accessToken = auth()->user()->access_token;
        $calendarId = 'primary';
        $attendees = $request->attendees;

        $url = 'https://www.googleapis.com/calendar/v3/calendars/' . urlencode($calendarId) . '/events';

        $eventData = [
            'summary' => $request->subject,
            'start' => [
                'dateTime' => '2023-05-26T09:00:00',
                'timeZone' => 'UTC', 
            ],
            'end' => [
                'dateTime' => '2023-05-26T10:00:00',
                'timeZone' => 'UTC', 
            ],
            'attendees' => array_map(function ($email) {
                return ['email' => $email];
            }, $attendees),
        ];

        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($eventData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response) {
            $responseArray = json_decode($response, true);
        } else {
            dd('Failed to create event. due to Curl error: ' . curl_error($ch));
        }

        return $responseArray;
    }
}