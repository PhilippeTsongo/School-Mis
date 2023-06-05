<?php

namespace App\Models;

use App\Models\TypeRecette;
use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AutreRecette extends Model
{
    use HasFactory;

    protected $fillable = ['recette_number', 'type_recette_id', 'montant', 'description', 'date_creation', 'mois', 'annee', 'academic_year_id'  ];

    public function type_recette ()
    {
        return $this->belongsTo(TypeRecette::class);
    }

    public function academic_year ()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
