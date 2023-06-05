<?php

namespace App\Models;

use App\Models\Cycle;
use App\Models\Course;
use App\Models\Student;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = ['class_number', 'name', 'slug_name', 'department_id', 'cycle_id'];

    public function department ()
    {
        return $this->belongsTo(Departement::class);
    }

    public function cycle ()
    {
        return $this->belongsTo(Cycle::class);
    }

    public function courses ()
    {
        return $this->hasMany(Course::class);
    }

    public function students ()
    {
        return $this->hasMany(Student::class);
    }

}
