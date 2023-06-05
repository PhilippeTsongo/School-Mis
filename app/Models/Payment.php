<?php

namespace App\Models;

use App\Models\Student;
use App\Models\PaymentType;
use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['payment_number', 'month', 'amount', 'payment_date', 'student_id', 'academic_year_id', 'payment_type_id'];

    public function student ()
    {
        return $this->belongs(Student::class);
    }

    public function academic_year ()
    {
        return $this->belongs(AcademicYear::class);
    }

    public function payement_type ()
    {
        return $this->belongs(PaymentType::class);
    }

}