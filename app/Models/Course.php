<?php

namespace App\Models;

use App\Models\Mark;
use App\Models\Classe;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'course_number', 'name', 'slug_name', 'short_name', 'lecturer_id', 'classe_id', 'max_mark', 'status'];

    public function lecturer ()
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function classe ()
    {
        return $this->belongsTo(Classe::class);
    }

    public function marks ()
    {
        return $this->hasMany(Mark::class);
    }
}


