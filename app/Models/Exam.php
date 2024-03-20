<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'uuid', 'subject_id', 'term', 'date', 'abbreviation', 
    ];

    public function class()
    {
        return $this->belongsTo(Clas::class, 'class_id', 'id')->withDefault(['name' => 'Not Defined']);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id')->withDefault(['name' => 'Not Defined']);
    }
}
