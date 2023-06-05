<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Student;
use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = ['cat1', 'cat2', 'cat3', 'student_id', 'course_id', 'academic_year'];

    public function student ()
    {
        return $this->belongs(Student::class);
    }

    public function course ()
    {
        return $this->belongs(Course::class);
    }

    public function academic_year ()
    {
        return $this->belongs(AcademicYear::class);
    }
    
}

