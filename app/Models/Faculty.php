<?php

namespace App\Models;

use App\Models\Cycle;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = ['faculty_number', 'name', 'slug_name', 'cycle_id'];
    
    public function department ()
    {
        return $this->hasMany(Department::class);
    }

    public function cycle ()
    {
        return $this->belongsTo(Cycle::class);
    }
}