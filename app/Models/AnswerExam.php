<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerExam extends Model
{
    use HasFactory;

    protected $table = 'answers_exam';

    // الأعمدة القابلة للتعبئة
    protected $fillable = [
        'exam_id',
        'question_id',
        'answer_id',
        'user_id',
    ];

    // العلاقة مع جدول الامتحانات
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    // العلاقة مع جدول الأسئلة
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    // العلاقة مع جدول الإجابات
    public function answer()
    {
        return $this->belongsTo(Answer::class, 'answer_id');
    }

    // العلاقة مع جدول المستخدمين
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
