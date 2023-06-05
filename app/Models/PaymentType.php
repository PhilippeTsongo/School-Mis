<?php

namespace App\Models;

use App\Models\Classe;
use App\Models\Payment;
use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentType extends Model
{
    use HasFactory;

    protected $fillable = ['payment_type', 'name', 'slug_name', 'total_amount', 'date_creation', 'classe_id', 'academic_year_id'];

    public function classe ()
    {
        return $this->belongsTo(Classe::class);
    }

    public function academic_year ()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function payments ()
    {
        return $this->hasMany(Payment::class);
    }
}
