<?php

namespace App\Models;

use App\Models\Mark;
use App\Models\User;
use App\Models\Classe;
use App\Models\Payment;
use App\Models\Section;
use App\Models\AcademicYear;
use App\Models\StudentParent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['student_number', 'date_of_birth', 'gender', 'address', 'tel', 'user_id', 'student_parent_id', 'section_id', 'classe_id', 'academic_year_id', 'status'];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function student_parent ()
    {
        return $this->belongsTo(StudentParent::class);
    }

    public function section ()
    {
        return $this->belongsTo(Section::class);
    }

    public function classe ()
    {
        return $this->belongsTo(Classe::class);
    }

    public function academic_year ()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function marks ()
    {
        return $this->hasMany(Mark::class);
    }

    public function payments ()
    {
        return $this->hasMany(Payment::class);
    }
    
}



