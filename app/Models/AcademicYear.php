<?php

namespace App\Models;

use App\Models\Mark;
use App\Models\Budget;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Timetable;
use App\Models\AutreRecette;
use App\Models\PrevisionBudget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = ['academic_number', 'year_range'];

    public function courses ()
    {
        return $this->hasMany(Expense::class);
    }

    public function marks ()
    {
        return $this->hasMany(Mark::class);
    }

    public function payments ()
    {
        return $this->hasMany(Payment::class);
    }

    public function budgets ()
    {
        return $this->hasMany(Budget::class);
    }

    public function students ()
    {
        return $this->hasMany(Student::class);
    }

    public function time_table ()
    {
        return $this->hasMany(Timetable::class);
    }

    public function autre_recettes ()
    {
        return $this->hasMany(AutreRecette::class);
    }
    
}
