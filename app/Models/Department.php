<?php

namespace App\Models;

use App\Models\Classe;
use App\Models\Faculty;
use App\Models\HeadDepartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['dept_number', 'name', 'slug_name', 'faculty_id'];

    public function classe ()
    {
        return $this->hasMany(Classe::class);
    }

    public function faculty ()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function head_department ()
    {
        return $this->hasOne(HeadDepartment::class);
    }
}
