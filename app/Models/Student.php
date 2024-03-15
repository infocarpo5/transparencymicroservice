<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'uuid', 'class_id', 'gender', 'parent_phone', 'parent_name', 'parent_email', 'reg', 'yearAdmitted',
    ];

    public function class()
    {
        return $this->belongsTo(Clas::class, 'class_id', 'id')->withDefault(['name' => 'Not Defined']);
    }
}
