<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'uuid', 'class_id','unit'
    ];

    public function class()
    {
        return $this->belongsTo(Clas::class, 'class_id', 'id')->withDefault(['name' => 'Not Defined']);
    }
}
