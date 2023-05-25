<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = ['subject', 'date', 'time', 'attendee1_email', 'attendee2_email', 'creater_id'];
}
