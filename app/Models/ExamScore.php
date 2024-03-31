<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamScore extends Model
{
    use HasFactory;

    protected $fillable = [
     'student_id', 'class_id', 'exam_id', 'score', 'uuid', 'is_published'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'student_id', 'id')->withDefault(['full_name' => 'Not Defined']);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id', 'id')->withDefault(['name' => 'Not Defined']);
    }
}
