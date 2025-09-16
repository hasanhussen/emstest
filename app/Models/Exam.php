<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subject_id',
        'exam_date',
        'start_time',
        'end_time',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
