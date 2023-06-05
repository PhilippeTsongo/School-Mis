<?php

namespace App\Models;

use App\Models\TypeBudget;
use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = ['type_budget_id', 'amount', 'academic_year_id', 'description'];

    public function type_budget ()
    {
        return $this->belongsTo(TypeBudget::class);
    }

    public function academic_year ()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
