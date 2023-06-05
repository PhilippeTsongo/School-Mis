<?php

namespace App\Models;

use App\Models\Classe;
use App\Models\Faculty;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cycle extends Model
{
    use HasFactory;

    protected $filllable = ['cycle_number', 'name', 'slug_name'];

    public function classe ()
    {
        return $this->hasMany(Classe::class);
    }

    public function faculty ()
    {
        return $this->hasMany(Faculty::class);
    }

    public function students ()
    {
        return $this->hasMany(Student::class);
    }

    
}
