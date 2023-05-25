<?php

namespace App\Http\Controllers\Meeting;

use App\Concern\GoogleCalenderService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMeetingRequest;
use App\Models\Meeting;

class MeetingController extends Controller
{
    public function __construct(protected GoogleCalenderService $googleCalender) {}

    public function create()
    {
        return view('meeting.create');
    }

    public function store(StoreMeetingRequest $request)
    {
        try {
            $data = $request->all();
            $data['attendee1_email'] = $request->attendees[0];
            $data['attendee2_email'] = $request->attendees[1];
            $data['creater_id'] = $request->user()->id;
    
            $meeting = Meeting::create($data);
    
            $responseArray = $this->googleCalender->saveMeetingInGoogleCalendar($request);

            if ($responseArray['status'] == 'confirmed') {
                return 'Meeting stored in DB and Google Calendar';
            }
        } 
        catch (\Exception $e) {
            return 'Failed to create meeeting due to: ' . $e->getMessage();
        }
    }
}
