<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'uuid', 'class_id', 'term', 'date', 'abbreviation', 'class_id'
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
