<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMeetingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subject' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'attendees' => 'required|array|size:2',
            'attendees.*' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'attendees.*.required' => 'Atleast one email is required',
        ];
    }
}
