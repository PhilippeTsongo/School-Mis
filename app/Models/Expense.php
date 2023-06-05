<?php

namespace App\Models;

use App\Models\ExpenseType;
use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['expense_number', 'expense_type_id', 'amount', 'expense_date', 'mois', 'annee', 'description', 'academic_year_id'];

    public function academic_year ()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function expense_type ()
    {
        return $this->belongsTo(ExpenseType::class);
    }
}