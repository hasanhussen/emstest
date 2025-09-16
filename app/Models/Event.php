<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    

     // إذا كنت تريد السماح بملء بيانات معينة فقط (من خلال الـ Mass Assignment)
    protected $fillable = [
        'name',
        'type',
        'event_date',
        'speakers',
        'participants',
    ];
}
